<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div id="frame">
            <div class="content">
                <div class="contact-profile">
                    <img src="{{ URL::asset('/storage/images/'.$list->AvaliableCourse->tutor->gettutorname->photo)}}" alt="" />
                    <p>{{$list->AvaliableCourse->tutor->gettutorname->fullname}}</p>
                </div>
        
                <div class="messages">
                    <ul>
                        @php ($x=0)
                        @php ($y=0)
                        @php($countt=0)
                        @php($counts=0)
                        @foreach($studentcomments as $scon)
                            @if($scon->tutorial_request_id == $list->id)
                                @php($x=$x+1)
                            @endif
                        @endforeach
                        @foreach($tutcomments as $tcon)
                            @if($tcon->tutorial_request_id == $list->id)
                                @php($y=$y+1)
                            @endif
                        @endforeach
                        @foreach($studentcomments as $scon)
                            @foreach($tutcomments as $tcon)
                                @if($tcon->tutorial_request_id == $list->id)
                                    @if($tcon->created_at < $scon->created_at)
                                        <li class="replies">
                                            <img src="{{ URL::asset('/storage/images/'.$list->AvaliableCourse->tutor->gettutorname->photo)}}" alt="" />
                                            <p>{{$tcon->description}}</p>
                                            <span class="time_date">{{$tcon->created_at}}</span>
                                            @php($countt=$countt+1)
                                        </li>
                
                                    @endif
                                @endif
                            @endforeach
                            @if($scon->tutorial_request_id == $list->id)
                                <li class="sent">
                                    <img src="{{ URL::asset('/storage/images/'.Auth::user()->photo)}}" alt="" />
                                    <p>{{$scon->description}}</p>
                                    <span class="time_date"> {{$scon->created_at}}</span>
                                    @php($counts=$counts+1)
                                </li>
                            @endif
                                
                        @endforeach
                        @if($counts<$x)
                            @for($i=$counts;$i<$x;$i++)
                                @if($studentcomments[$i]->tutorial_request_id == $list->id)
                                    <li class="sent">
                                        <img src="{{ URL::asset('/storage/images/'.Auth::user()->photo)}}" alt="" />
                                        <p>{{$studentcomments[$i]->description}}</p>
                                        <span class="time_date"> {{$studentcomments[$i]->created_at}}</span>
                        
                                    </li>
                                @endif
                            @endfor

                        @endif
                       
                        @if($countt<$y)
                            @for($i=$countt;$i<$y;$i++)
                                @if($tutcomments[$i]->tutorial_request_id == $list->id)
                                <li class="replies">
                                        <img src="{{ URL::asset('/storage/images/'.$list->AvaliableCourse->tutor->gettutorname->photo)}}" alt="" />
                                        <p>{{$tutcomments[$i]->description}}</p>
                                        <span class="time_date"> {{$tutcomments[$i]->created_at}}</span>
                                        
                                </li>
                                @endif
                            @endfor
                        @endif
                       
                    </ul>
                </div>
        
                <div class="message-input">
                    <div class="wrap">
                        <input type="text" id="input{{$list->id}}" placeholder="Write your message..." />
                        <button type="submit" class="submit" id="submit{{$list->id}}" value={{$list->id}}><i class="ri-send-plane-fill" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });
  $("#input{{$list->id}}").animate({ scrollTop: $(document).height() }, "fast");

  function newMessage{{$list->id}}() {
    message = $("#input{{$list->id}}").val();
    listid = $("#submit{{$list->id}}").val();
    if($.trim(message) == '') {
      return false;
    }
    $('<li class="sent"><img src="{{ URL::asset('/storage/images/'.Auth::user()->photo)}}" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
    $("#input{{$list->id}}").val(null);
    $('.contact.active .preview').html('<span>You: </span>' + message);
   

    var url="{{route('autosendstudent')}}";
    var id= listid;
    var q= message;
    
    $.ajax({
        url:url,
        method:'POST',
        data:{
          id:id,
          q:q
        },
       
    });
  };

  $('#submit{{$list->id}}').click(function() {
    newMessage{{$list->id}}();

  });

  $(window).on('keydown', function(e) {
    if (e.which == 13) {
      newMessage{{$list->id}}();
      return false;
    }
  });
    
</script>

