<div class="row gx-0">
    <div class="col-lg-4 col-xxl-3" id="chatTabs" role="tablist">
        <!-- Divider -->
        <div class="d-flex align-items-center mb-4 d-lg-none">
            <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="btn btn-primary fw-bold fa-solid fa-sliders"></i>
            <span class="h6 mb-0 fw-bold d-lg-none ms-2">Chats</span>
            </button>
        </div>
        <!-- Advanced filter responsive toggler END -->
        <div class="card card-body border-end-0 border-bottom-0 rounded-bottom-0">
            <div class=" d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0">THEZOOM</h1>
            </div>
        </div>

        <nav class="navbar navbar-light navbar-expand-lg mx-0">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <!-- Offcanvas header -->
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"></button>
                        </div>

            <!-- Offcanvas body -->
            <div class="offcanvas-body p-0">
            <div class="card card-chat-list rounded-end-lg-0 card-body border-end-lg-0 rounded-top-0">
                
                <!-- Search chat START -->
                <form class="position-relative">
                <input class="form-control py-2" type="search" placeholder="Search for chats" aria-label="Search">
                <button class="btn bg-transparent text-secondary px-2 py-0 position-absolute top-50 end-0 translate-middle-y" type="submit">
                    <i class="bi bi-search fs-5"></i>
                </button>
                </form>
                <!-- Search chat END -->
                
                <!-- Chat list tab START -->
                <div class="mt-4 h-100">
                <div class="chat-tab-list custom-scrollbar">
                    <ul wire:poll.visible class="nav flex-column nav-pills nav-pills-soft">
                        @foreach ($conversations as $conversation)
                            @if ($conversation->sender_id == $userId)
                                @for ($m = 0; $m < $alluser_count; $m++)
                                @if ($alluser[$m]['id'] == $conversation->receiver_id)
                                    <li data-bs-dismiss="offcanvas">
                                        <form wire:submit="result({{$conversation->id}})" >
                                            <div class="d-grid gap-2">
                                                <button id="btn" type="submit">
                                                    <div class="nav-link active text-start" id="chat-1-tab" data-bs-toggle="pill" role="tab">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar me-2 ">
                                                                <img class="avatar-img rounded-circle" src="{{$alluser[$m]['profile_pic']}}" alt="">
                                                            </div>
                                                            <div class="flex-grow-1 d-block">
                                                            <h6 class="mb-0 mt- "> {{$alluser[$m]['user_name']}}</h6>
                                                            <div class="small text-secondary">last message ...</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </div>
                                        </form>
                                    </li>
                                @endif
                                @endfor 
                            @else
                                @for ($m = 0; $m < $alluser_count; $m++)
                                @if ($alluser[$m]['id'] == $conversation->sender_id)
                                    <li data-bs-dismiss="offcanvas">
                                        <form wire:submit="result({{$conversation->id}})" >
                                            <div class="d-grid gap-2">
                                                <button id="btn" type="submit">
                                                    <div class="nav-link active text-start" id="chat-1-tab" data-bs-toggle="pill" role="tab">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar me-2 ">
                                                                <img class="avatar-img rounded-circle" src="{{$alluser[$m]['profile_pic']}}" alt="">
                                                            </div>
                                                            <div class="flex-grow-1 d-block">
                                                            <h6 class="mb-0 mt-1"> {{$alluser[$m]['user_name']}}</h6>
                                                            <div class="small text-secondary">last message ...</div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </button>
                                            </div>
                                        </form>
                                    </li>
                                @endif
                                @endfor 
                            @endif
                        @endforeach
                    
                    </ul>
                </div>
                </div>
                <!-- Chat list tab END -->
            </div>
            </div>
        </div>
        </nav>
    </div>
    
    <!-- Chat conversation START -->
    <div  class="col-lg-8 col-xxl-9">
        <div class="card card-chat rounded-start-lg-0 border-start-lg-0">
            <div class="card-body h-100">
                <div class="tab-content py-0 mb-0 h-100" id="chatTabsContent">
                    <!-- Conversation item START -->
                    <div class="fade tab-pane show active h-100" id="chat-1" role="tabpanel" aria-labelledby="chat-1-tab">
                    <!-- Top avatar and status START -->
                    <div class="d-sm-flex justify-content-between align-items-center">   
                        @for ($j = 0; $j < $alluser_count; $j++)
                            @if ($alluser[$j]['id'] == $user_in_chat)
                            <div class="d-flex mb-2 mb-sm-0">

                                <div class="flex-shrink-0 avatar me-2">
                                    <img class="avatar-img rounded-circle" src="{{$alluser[$j]['profile_pic']}}" alt="{{$alluser[$j]['user_name']}}">
                                </div>

                                <div class="d-block flex-grow-1">
                                    <h6 class="mb-0 mt-1">{{$alluser[$j]['user_name']}}</h6>
                                    <div class="small text-secondary">{{$alluser[$j]['first_name']}} {{$alluser[$j]['last_name']}}</div>
                                </div>

                                </div>
                                <div class="d-flex align-items-center">
                                    <!-- Call button -->
                                    <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Audio call"><i class="bi bi-telephone-fill"></i></a>
                                    <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Video call"><i class="bi bi-camera-video-fill"></i></a>
                                    <!-- Card action START -->
                                    <div class="dropdown">
                                        <a class="icon-md rounded-circle btn btn-primary-soft me-2 px-2" href="#" id="chatcoversationDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>               
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatcoversationDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-check-lg me-2 fw-icon"></i>Mark as read</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-mic-mute me-2 fw-icon"></i>Mute conversation</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-check me-2 fw-icon"></i>View profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2 fw-icon"></i>Delete chat</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2 fw-icon"></i>Archive chat</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif  
                        @endfor
                    </div>

                    <hr>

                        <!-- Chat conversation START -->
                        @if ($user_in_chat)
                            <div wire:poll.visible style="height: calc(100% - 160px); overflow-y:scroll"  class="chat-conversation-content custom-scrollbar">
                                @for ($i = 0; $i < $show_messages_count; $i++)
                                    @if ( $show_messages[$i]['sender_id'] == $userId )
                                        <!-- Chat message right -->
                                        <div div class="d-flex justify-content-end text-end mb-1">
                                            <div class="w-100">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="bg-primary text-white p-2 px-3 rounded-2">{{$show_messages[$i]['body']}} 
                                                    <br> <small style="font-size: 10px" class="small my-2">{{$show_messages[$i]['created_at']->format('H:i')}}</small>
                                                </div>
                                            </div>
                                            </div>
                                        </div>  
                                    @else
                                        <!-- Chat message left -->
                                        <div class="d-flex mb-1">
                                            <div class="flex-grow-1">
                                                <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">{{$show_messages[$i]['body']}}
                                                        <br> <small style="font-size: 10px" class="small my-2">{{$show_messages[$i]['created_at']->format('H:i')}}</small>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>  
                                    @endif
                                @endfor
                            </div>
                        @endif
                        <!-- Conversation item END -->

                        <!-- Chat input START -->
                        @if ($user_in_chat)
                            <div class="card-footer w-full px-0">                 
                                <form class="d-flex gap-1 items-stretch w-full" wire:submit="save({{$user_in_chat}})" >
                                    <input wire:model="message" name="message" id="cmnt-input" class="form-control py-2 w-full" type="text" placeholder="Add Comment ..." aria-label="Search">
                                    <button class="btn btn-light" id="cmnt-btn" type="submit"> <i class="fa-solid fa-paper-plane fs-6"></i></button>
                                </form>
                            </div>
                        @endif    
                        <!-- Chat input END -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>