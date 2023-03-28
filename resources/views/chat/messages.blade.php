
                              @if(!empty($messages))
                              @foreach ($messages as $message)
                                 @if( $message['from'] == $user['id'])
                                     @if($message['type']== "text")
                                     <li class="clearfix">
                                         <div class="message other-message pull-right">

                                             @if(strtotime('-1 day') < strtotime($message['time'])) <div class="message-data text-right"><span class="message-data-time">{{$message['time']}}</span></div>
                                             @else
                                             <div class="message-data text-right"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                             @endif
                                             {{$message['message']}}
                                             </div>
                                         </li>
                                     @elseif ($message['type']== "image")
                                         <li class="clearfix">
                                             <div class="message other-message pull-right">
                                                 @if(strtotime('-1 day') < strtotime($message['time']))
                                                 <div class="message-data text-right"><span class="message-data-time">{{$message['time']}}</span></div>
                                                 @else
                                                     <div class="message-data text-right"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                                 @endif
                                                 <img src={{$message['message']}} class="css-class" alt="alt text" style="width:200px;height:200px;">
                                             </div>
                                         </li>
                                     @else
                                         <li class="clearfix">
                                             <div class="message other-message pull-right">
                                                 @if(strtotime('-1 dia') < strtotime($message['time'])) <div class="message-data"><span class="message-data-time">{{$message['time']}}</span>
                                                 </div>
                                                 @else
                                                 <div class="message-data"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                                 @endif
                                                 <a href="{{ route('chat.downloadfile', $message['messageID'])}}"><img src="../assets/images/default/file.png" style="width:42px;height:42px;"></a>
                                             </div>
                                         </li>
                                     @endif
                                 @else
                                    @if($message['type']== "text")
                                    <li>
                                       <div class="message my-message ">

                                       @if(strtotime('-1 day') < strtotime($message['time'])) <div class="message-data text-right"><span class="message-data-time">{{$message['time']}}</span></div>
                                          @else
                                          <div class="message-data text-right"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                          @endif
                                          {{$message['message']}}
                                       </div>
                                    </li>
                                    @elseif ($message['type']== "image")
                                         <li>
                                             <div class="message my-message">

                                                 @if(strtotime('-1 day') < strtotime($message['time'])) <div class="message-data text-right"><span class="message-data-time">{{$message['time']}}</span>
                                                 </div>
                                                 @else
                                                 <div class="message-data text-right"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                                 @endif

                                                 <img src={{$message['message']}} class="css-class" alt="alt text" style="width:200px;height:200px;">
                                             </div>
                                         </li>
                                    @else
                                         <li>
                                             <div class="message my-message">

                                             @if(strtotime('-1 day') < strtotime($message['time'])) <div class="message-data text-right"><span class="message-data-time">{{$message['time']}}</span>
                                             </div>
                                             @else
                                             <div class="message-data text-right"><span class="message-data-time">{{$message['time']}} de {{$message['date']}}</span></div>
                                             @endif

                                             <a href="{{ route('chat.downloadfile', $message['messageID'])}}"><img src="../assets/images/default/file.png" style="width:42px;height:42px;"></a>
                                             </div>
                                         </li>

                                    @endif
                                 @endif
                              @endforeach
                           @endif
