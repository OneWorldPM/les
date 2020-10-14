var meetingsTable;

$(function() {

    var newMeetingSelectedAttendees = [];

    $('.lounge-meetings-btn').on('click', function () {
        listMeetings();
        $('#meetings-modal').modal('show');
    });

    $('.lounge-new-meeting-btn').on('click', function () {
        $('#new-meeting-modal').modal('show');
    });

    $('.attendees-search').on('input', function() {
        var searchTerm = $(this).val();

        if (searchTerm == '')
            return;

        $.get( base_url+"Lounge/searchAttendees/"+searchTerm, function(result) {
            result = JSON.parse(result);

            if (result.length == 0)
                return;

            $('.attendees-suggestions').html('');
            $.each( result, function( row, user ) {

                var fullname = user.first_name+' '+user.last_name;
                if (fullname == ' ')
                {
                    var fullname = 'Name Unavailable';
                }
                var nameAcronym = fullname.match(/\b(\w)/g).join('');
                var color = md5(nameAcronym+user.cust_id).slice(0, 6);
                var userAvatarSrc = (user.profile != '' && user.profile != null)?base_url+'uploads/customer_profile/'+user.profile:'https://placehold.it/50/'+color+'/fff&amp;text='+nameAcronym;
                var userAvatarAlt = 'https://placehold.it/50/'+color+'/fff&amp;text='+nameAcronym;

                $('.attendees-suggestions').append(
                    '<li class="attendees-suggestions-item list-group-item" attendee-id="'+user.cust_id+'" attendee-name="'+user.first_name+' '+user.last_name+'" userAvatarAlt="'+userAvatarAlt+'"><img src="'+userAvatarSrc+'" alt="User Avatar" onerror=this.src="'+userAvatarAlt+'" class="img-circle"> '+user.first_name+' '+user.last_name+' </li>'
                );
            });

        });
    });


    $(".attendees-suggestions").on('click', '.attendees-suggestions-item',function () {
        var id = $(this).attr('attendee-id');
        var name = $(this).attr('attendee-name');
        var userAvatarSrc = $(this).children("img").attr('src');
        var userAvatarAlt = $(this).attr('userAvatarAlt');

        if (id == user_id)
        {
            toastr["warning"]("You are the host, you can't add yourself as an attendee!");
            return;
        }

        $('.selected-attendees-list').append(
            '<div class="selected-attendees-item" attendee-id="'+id+'"><img src="'+userAvatarSrc+'" alt="User Avatar" onerror=this.src="'+userAvatarAlt+'" class="img-circle"> '+name+' <i class="remove-attendee fa fa-times" attendee-id="'+id+'" aria-hidden="true" style="color: #c60d0d;"></i></div>'
        );

        addAttendee(newMeetingSelectedAttendees, id);

        $('.attendees-suggestions').html('');
        $('.attendees-search').val('');

    });

    $(".selected-attendees-list").on('click', '.remove-attendee',function () {
        var id = $(this).attr('attendee-id');

        $('.selected-attendees-item[attendee-id="'+id+'"]').remove();
        removeAttendee(newMeetingSelectedAttendees, id)
    });


    $('.create-meeting').on('click', function () {

        var topic = $('.meeting-topic').val();
        var from = $('.meeting-from').val();
        // var to = $('.meeting-to').val();

        if (topic == ''){
            toastr["warning"]("Please enter a meeting topic!");
            return;
        }

        if (from == ''){
            toastr["warning"]("Please choose a starting time!");
            return;
        }

        // if (to == ''){
        //     toastr["warning"]("Please choose an ending time!");
        //     return;
        // }

        if (newMeetingSelectedAttendees.length == 0){
            toastr["warning"]("You need to add at least one attendee!");
            return;
        }

        $.post(base_url+"Lounge/newMeeting",
            {
                'topic': topic,
                'from': from,
                'attendees': newMeetingSelectedAttendees
            },
            function(data, status){
                if(status == 'success')
                {
                    data = JSON.parse(data);

                    if (data.status == 'success')
                    {
                        Swal.fire(
                            'Done!',
                            'Your meeting has been scheduled and invites are sent!',
                            'success'
                        );

                        listMeetings();

                        $('#new-meeting-modal').modal('hide');

                        $('.attendees-suggestions').html('');
                        $('.attendees-search').val('');
                        $('.selected-attendees-list').html('');
                        $('.meeting-topic').val('');
                        $('.meeting-from').val('');
                        $('.meeting-to').val('');
                    }

                }else{
                    toastr["error"]("Network problem!");
                }
            });


    });

    fillFutureMeetingsNumber();
});

function fillFutureMeetingsNumber() {
    $.get( base_url+"Lounge/getFutureMeetingsNumber/"+user_id, function(result) {
        result = JSON.parse(result);

        if (result.length == 0)
            return;

        $('.number-of-meet-badge').html(result.length);
    });
}


function listMeetings() {

    $.get( base_url+"Lounge/getMeetings/"+user_id, function(result) {
        result = JSON.parse(result);

        $('#meetings_table').dataTable().fnDestroy();
        $('.meetings-table-items').html("");

        $.each( result, function( row, meeting ) {
            if (meeting.host == user_id)
            {
                var meeting_delete_button = '<button class="delete-meeting-btn btn btn-xs btn-danger m-t-5" meeting-id="'+meeting.id+'">Delete</button>';
            }else{
                var meeting_delete_button = '';
            }

            $('.meetings-table-items').append(
                '<tr>\n' +
                '  <td>'+meeting.topic+'</td>\n' +
                '  <td>'+meeting.host_name+'</td>\n' +
                '  <td>'+meeting.meeting_from+'</td>\n' +
                '  <td>'+meeting.meeting_to+'</td>\n' +
                '  <td>' +
                '<button class="show-attendees-btn btn btn-xs btn-warning m-b-5" meeting-id="'+meeting.id+'">Attendees</button>' +
                '<a class="m-t-5" href="'+base_url+'lounge/meet/'+meeting.id+'" target="_blank"><button class="meeting-room-btn btn btn-xs btn-info" meeting-id="'+meeting.id+'">Meeting Room</button></a>' +
                 meeting_delete_button +
                '</td>\n' +
                '</tr>'
            );
        });

        $('#meetings_table').DataTable();
    });

}

$(".meetings-table-items").on('click', '.delete-meeting-btn',function () {
    var meeting_id = $(this).attr('meeting-id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post(base_url+"Lounge/deleteMeeting",
                {
                    'meetingId': meeting_id
                },
                function(data, status){
                    if(status == 'success')
                    {
                        data = JSON.parse(data);

                        if (data.status == 'success')
                        {
                            Swal.fire(
                                'Deleted!',
                                'Meeting has been deleted.',
                                'success'
                            )

                            listMeetings();
                        }

                    }else{
                        toastr["error"]("Network problem!");
                    }
                });
        }
    })
});
$(".meetings-table-items").on('click', '.show-attendees-btn',function () {
    var meeting_id = $(this).attr('meeting-id');

    $.post(base_url+"Lounge/getMeetingAttendees",
        {
            'meetingId': meeting_id
        },
        function(data, status){
            if(status == 'success')
            {
                data = JSON.parse(data);
                $('.attendees-list').html('');
                $.each( data, function( row, user ) {

                    var fullname = user.name;
                    if (fullname == '')
                    {
                        fullname = 'Name Unavailable';
                    }
                    var nameAcronym = fullname.match(/\b(\w)/g).join('');
                    var color = md5(nameAcronym+user.cust_id).slice(0, 6);
                    var userAvatarSrc = (user.profile != '' && user.profile != null)?base_url+'uploads/customer_profile/'+user.profile:'https://placehold.it/50/'+color+'/fff&amp;text='+nameAcronym;
                    var userAvatarAlt = 'https://placehold.it/50/'+color+'/fff&amp;text='+nameAcronym;

                    $('.attendees-list').append('<p><img src="'+userAvatarSrc+'" alt="User Avatar" onerror=this.src="'+userAvatarAlt+'" class="img-circle"> '+user.name+'</p>');
                });

                $('#attendees_per_meet_modal').modal('show');
            }else{
                toastr["error"]("Network problem!");
            }
        });
});



function addAttendee(newMeetingSelectedAttendees, attendee) {
    newMeetingSelectedAttendees.push(attendee);
    return newMeetingSelectedAttendees;
}

function removeAttendee(newMeetingSelectedAttendees, attendee) {
    var index = newMeetingSelectedAttendees.indexOf(attendee);
    if (index > -1) {
        newMeetingSelectedAttendees.splice(index, 1);
    }
    return newMeetingSelectedAttendees;
}
