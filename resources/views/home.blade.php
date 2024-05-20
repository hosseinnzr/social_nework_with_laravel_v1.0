@extends('layout')
@section('title', 'home')
@section('content')
@auth
{{ csrf_field() }}


<main>      
  <!-- Container START -->
  <div class="container">
    <div class="row g-4">

      <!-- Sidenav START -->
      <div class="col-lg-3">

        <!-- Advanced filter responsive toggler START -->
        <div class="d-flex align-items-center d-lg-none">
          <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSideNavbar" aria-controls="offcanvasSideNavbar">
            <i class="btn btn-primary fw-bold fa-solid fa-sliders-h"></i>
            <span class="h6 mb-0 fw-bold d-lg-none ms-2">My profile</span>
          </button>
        </div>
        <!-- Advanced filter responsive toggler END -->
        
        <!-- Navbar START-->
        <nav class="navbar navbar-expand-lg mx-0"> 
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
            <!-- Offcanvas header -->
            <div class="offcanvas-header">
              <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close" aria-atomic="flase" data-bs-autohide="false"></button>
            </div>

            <!-- Offcanvas body -->
            <div class="offcanvas-body d-block px-2 px-lg-0">
              <!-- Card START -->
              <div class="card overflow-hidden">
                <!-- Cover image -->
                <div class="h-50px" style="background-image:url(assets/images/bg/01.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                  <!-- Card body START -->
                  <div class="card-body pt-0">
                    <div class="text-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-xl mt-n5 mb-3">
                      <a href="#!"><img class="avatar-img rounded border border-white border-3" src="{{auth()->user()->profile_pic}}" alt=""></a>
                    </div>

                    <!-- Info -->
                    <h5 class="mb-0"> <a href="/user/{{auth()->user()->user_name}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a> </h5>
                    <small>{{auth()->user()->email}}</small>
                    <p class="mt-3">{{auth()->user()->biography}}</p>

                    <!-- post, follow, following START -->
                      <x-post-follower-following :user="auth()->user()"/>
                    <!-- post, follow, following END -->

                  </div>

                  <!-- Divider -->
                  <hr>

                  <!-- Side Nav START -->
                  <ul class="nav nav-link-secondary flex-column fw-bold gap-0">
                    <li class="nav-item">
                      <div class=" text-center py-0">
                        <a class="btn btn-link text-secondary btn-sm" type="submit" href="{{ route('profile', ['user_name' => Auth::user()->user_name]) }}">view Profile </a>
                      </div>
                    </li>

                  </ul>
                  <!-- Side Nav END -->
                </div>
                <!-- Card body END -->
              </div>
              <!-- Card END -->
            </div>
          </div>
        </nav>
        <!-- Navbar END-->
      </div>
      <!-- Sidenav END -->


      
      <!-- Main content START -->
      <div class="col-md-8 col-lg-6 vstack gap-4">

        <!-- Card feed item START -->
        @foreach ($posts as $post)

          <div class="card">
            <!-- Card header START -->
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar me-2">
                    <a href="#!"> <img class="avatar-img rounded-circle" src="{{$post['user_profile_pic']}}" alt="user_img"> </a>
                    </div>
                    <!-- Info -->
                    <div>
                    <h6 class="card-title mb-0"> <a href="/user/{{$post['user_name']}}">  {{$post['user_name']}}   </a></h6>
                    <p class="small mb-0">{{$post['created_at']->diffForHumans()}}</p>
                    </div>
                </div>
                <!-- Card share action START -->
                <div class="dropdown">
                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardShareAction8" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                    </a>
                    <!-- Card share action dropdown menu -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a></li>
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow {{$post['user_name']}}</a></li>
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block {{$post['user_name']}}</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                    </ul>
                </div>
                <!-- Card share action START -->
                </div>
            </div>
            <!-- Card header START -->
            
            <!-- Card body START -->
            <div class="card-body">
                <h5>{{$post['title']}}</h5>
                <p class="mb-0">{{$post['post']}}</p>
                <br>
                
                @isset($post['post_picture'])
                <img class="card-img" src="{{$post['post_picture']}}" alt="Post">
                <br>    
                @endisset 
                
                @foreach(explode(",", $post['tag']) as $tag)
                <a href="/?tag={{$tag}}">{{$tag}} </a>
                @endforeach
            </div>
            <!-- Card body END -->
    
            <!-- Card Footer START -->
            <div class="card-footer py-3"> 
                <!-- Feed react START -->
              <ul class="nav nav-fill nav-stack small">

                <li class="nav-item">
                  @livewire('like-post', ['post' => $post])
                </li>

                <li class="nav-item">
                  <div data-bs-toggle="modal" data-bs-target="#showComments{{$post['id']}}" aria-controls="offcanvasChat">
                    <small style="text-align: center" class="mb-0"> <i class="bi bi-chat-fill pe-1"></i> Comments</small>
                  </div>
                </li>

                  <!-- scroll show comment START -->
                  <div class="modal fade" id="showComments{{$post['id']}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">

                        <!-- Modal feed header START -->
                        <div class="modal-header">
                          <h6 class="modal-title">Comments </h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal feed header END -->

                        <!-- show post START -->
                          <!-- Card body START -->
                          <div class="card-body">
                              <h5>{{$post['title']}}</h5>
                              <p class="mb-0">{{$post['post']}}</p>
                              <br>
                              
                              @isset($post['post_picture'])
                              <img class="card-img" src="{{$post['post_picture']}}" alt="Post">
                              <br>    
                              @endisset 

                          </div>
                          <!-- Card body END -->
                        <br>
                        <!-- show post END -->

                        @livewire('add-comments', ['postId' => $post['id'], 'post' => $post])
                      </div>
                    </div>
                  </div>
                  <!-- scroll show comment END -->

                <li class="nav-item">
                    <form action="#" method="POST" class="ms-auto me-auto mt-3">
                        @csrf
                        <button style="font-size: 12px" type="submit" class="btn btn-link"><i class="bi bi-send-fill pe-1"></i>Send</button>
                    </form>
                </li>
              </ul>
                <!-- Feed react END -->
            </div>
            <!-- Card Footer END -->
    
          </div>

        @endforeach
        <!-- Card feed item END -->

        <br>

      </div>
      <!-- Main content END -->

      <!-- Right sidebar START -->
      <div class="col-lg-3">
        <div class="row g-4">
          <!-- Card follow START -->
          <div class="col-sm-6 col-lg-12">
            <div class="card">
              <!-- Card header START -->
              <div class="card-header pb-0 border-0">
                <h5 class="card-title mb-0">New Users</h5>
              </div>
              <!-- Card header END -->

              <!-- Card body START -->
              <div class="card-body">
                <!-- Connection item START -->
                <div class="hstack gap-2 mb-3">
                  <!-- Avatar -->
                  <div class="avatar">
                    <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt=""></a>
                  </div>
                  <!-- Title -->
                  <div class="overflow-hidden">
                    <a class="h6 mb-0" href="#!">Judy Nguyen </a>
                    <p class="mb-0 small text-truncate">News anchor</p>
                  </div>
                  <!-- Button -->
                  <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus"> </i></a>
                </div>
                <!-- Connection item END -->
                
                <!-- Connection item START -->
                  <div class="hstack gap-2 mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-story">
                      <a href="#!"> <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt=""> </a>
                    </div>
                    <!-- Title -->
                    <div class="overflow-hidden">
                      <a class="h6 mb-0" href="#!">Amanda Reed </a>
                      <p class="mb-0 small text-truncate">Web Developer</p>
                    </div>
                    <!-- Button -->
                    <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus"> </i></a>
                </div>
                <!-- Connection item END -->

                <!-- Connection item START -->
                <div class="hstack gap-2 mb-3">
                  <!-- Avatar -->
                  <div class="avatar">
                    <a href="#"> <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt=""> </a>
                  </div>
                  <!-- Title -->
                  <div class="overflow-hidden">
                    <a class="h6 mb-0" href="#!">Billy Vasquez </a>
                    <p class="mb-0 small text-truncate">News anchor</p>
                  </div>
                  <!-- Button -->
                  <a class="btn btn-primary rounded-circle icon-md ms-auto" href="#"><i class="bi bi-person-check-fill"> </i></a>
                </div>
                <!-- Connection item END -->
                
                <!-- Connection item START -->
                <div class="hstack gap-2 mb-3">
                  <!-- Avatar -->
                  <div class="avatar">
                    <a href="#"> <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt=""> </a>
                  </div>
                  <!-- Title -->
                  <div class="overflow-hidden">
                    <a class="h6 mb-0" href="#!">Lori Ferguson </a>
                    <p class="mb-0 small text-truncate">Web Developer at Webestica</p>
                  </div>
                  <!-- Button -->
                  <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus"> </i></a>
                </div>
                <!-- Connection item END -->

                <!-- Connection item START -->
                <div class="hstack gap-2 mb-3">
                  <!-- Avatar -->
                  <div class="avatar">
                    <a href="#"> <img class="avatar-img rounded-circle" src="assets/images/avatar/placeholder.jpg" alt=""> </a>
                  </div>
                  <!-- Title -->
                  <div class="overflow-hidden">
                    <a class="h6 mb-0" href="#!">Carolyn Ortiz </a>
                    <p class="mb-0 small text-truncate">News anchor</p>
                  </div>
                  <!-- Button -->
                  <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus"> </i></a>
                </div>
                <!-- Connection item END -->

                <!-- View more button -->
                <div class="d-grid mt-3">
                  <a class="btn btn-sm btn-primary-soft" href="#!">View more</a>
                </div>
              </div>
              <!-- Card body END -->
            </div>
          </div>
          <!-- Card follow START -->

          <!-- Card News START -->
          <div class="col-sm-6 col-lg-12">
            <div class="card">
              <!-- Card header START -->
              <div class="card-header pb-0 border-0">
                <h5 class="card-title mb-0">Today’s news</h5>
              </div>
              <!-- Card header END -->
              <!-- Card body START -->
              <div class="card-body">
                <!-- News item -->
                <div class="mb-3">
                  <h6 class="mb-0"><a href="blog-details.html">Ten questions you should answer truthfully</a></h6>
                  <small>2hr</small>
                </div>
                <!-- News item -->
                <div class="mb-3">
                  <h6 class="mb-0"><a href="blog-details.html">Five unbelievable facts about money</a></h6>
                  <small>3hr</small>
                </div>
                <!-- News item -->
                <div class="mb-3">
                  <h6 class="mb-0"><a href="blog-details.html">Best Pinterest Boards for learning about business</a></h6>
                  <small>4hr</small>
                </div>
                <!-- News item -->
                <div class="mb-3">
                  <h6 class="mb-0"><a href="blog-details.html">Skills that you can learn from business</a></h6>
                  <small>6hr</small>
                </div>
                <!-- Load more comments -->
                <a href="#!" role="button" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center" data-bs-toggle="button" aria-pressed="true">
                  <div class="spinner-dots me-2">
                    <span class="spinner-dot"></span>
                    <span class="spinner-dot"></span>
                    <span class="spinner-dot"></span>
                  </div>
                  View all latest news
                </a>
              </div>
              <!-- Card body END -->
            </div>
          </div>
          <!-- Card News END -->
        </div>
      </div>
      <!-- Right sidebar END -->

    </div> <!-- Row END -->
  </div>  
  <!-- Container END -->

</main>

  <!-- Show follower/following START -->
    <x-show-follower-following :following="$following_user" :follower="$follower_user" />
  <!-- Show follower/following END -->

  <!-- Chat START -->
  <div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container toast-chat d-flex gap-3 align-items-end">

      <!-- Chat toast START -->
      <div id="chatToast" class="toast mb-0 bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header bg-mode">
          <!-- Top avatar and status START -->
          <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex">
              <div class="flex-shrink-0 avatar me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-0 mt-1">Frances Guerrero</h6>
                <div class="small text-secondary"><i class="fa-solid fa-circle text-success me-1"></i>Online</div>
              </div>
            </div>
            <div class="d-flex">
            <!-- Call button -->
            <div class="dropdown">
              <a class="btn btn-secondary-soft-hover py-1 px-2" href="#" id="chatcoversationDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>               
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatcoversationDropdown">
                <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video me-2 fw-icon"></i>Video call</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2 fw-icon"></i>Audio call</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2 fw-icon"></i>Delete </a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-square-text me-2 fw-icon"></i>Mark as unread</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-volume-up me-2 fw-icon"></i>Muted</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2 fw-icon"></i>Archive</a></li>
                <li class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2 fw-icon"></i>Report</a></li>
              </ul>
            </div>
            <!-- Card action END -->
            <a class="btn btn-secondary-soft-hover py-1 px-2" data-bs-toggle="collapse" href="#collapseChat" aria-expanded="false" aria-controls="collapseChat"><i class="bi bi-dash-lg"></i></a>        
            <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <!-- Top avatar and status END -->
          
        </div>
        <div class="toast-body collapse show" id="collapseChat">
          <!-- Chat conversation START -->
          <div class="chat-conversation-content custom-scrollbar h-200px">
            <!-- Chat time -->
            <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Applauded no discovery😊</div>
                    <div class="small my-2">6:15 AM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message right -->
            <div class="d-flex justify-content-end text-end mb-1">
              <div class="w-100">
                <div class="d-flex flex-column align-items-end">
                  <div class="bg-primary text-white p-2 px-3 rounded-2">With pleasure</div>
                </div>
              </div>
            </div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Please find the attached</div>
                    <!-- Files START -->
                    <!-- Files END -->
                    <div class="small my-2">12:16 PM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">How promotion excellent curiosity😮</div>
                    <div class="small my-2">3:22 PM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message right -->
            <div class="d-flex justify-content-end text-end mb-1">
              <div class="w-100">
                <div class="d-flex flex-column align-items-end">
                  <div class="bg-primary text-white p-2 px-3 rounded-2">And sir dare view.</div>
                  <!-- Images -->
                  <div class="d-flex my-2">
                    <div class="small text-secondary">5:35 PM</div>
                    <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat time -->
            <div class="text-center small my-2">2 New Messages</div>
            <!-- Chat Typing -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-3 rounded-2">
                      <div class="typing d-flex align-items-center">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Chat conversation END -->
          <!-- Chat bottom START -->
          <div class="mt-2">
            <!-- Chat textarea -->
            <textarea class="form-control mb-sm-0 mb-3" placeholder="Type a message" rows="1"></textarea>
            <!-- Button -->
            <div class="d-sm-flex align-items-end mt-2">
              <button class="btn btn-sm btn-danger-soft me-2"><i class="fa-solid fa-face-smile fs-6"></i></button>
              <button class="btn btn-sm btn-secondary-soft me-2"><i class="fa-solid fa-paperclip fs-6"></i></button>
              <button class="btn btn-sm btn-success-soft me-2"> Gif </button>
              <button class="btn btn-sm btn-primary ms-auto"> Send </button>
            </div>
          </div>
          <!-- Chat bottom START -->
        </div>
      </div>
      <!-- Chat toast END -->

      <!-- Chat toast 2 START -->
      <div id="chatToast2" class="toast mb-0 bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header bg-mode">
          <!-- Top avatar and status START -->
          <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex">
              <div class="flex-shrink-0 avatar me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-0 mt-1">Lori Ferguson</h6>
                <div class="small text-secondary"><i class="fa-solid fa-circle text-success me-1"></i>Online</div>
              </div>
            </div>
            <div class="d-flex">
            <!-- Call button -->
            <div class="dropdown">
              <a class="btn btn-secondary-soft-hover py-1 px-2" href="#" id="chatcoversationDropdown2" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>               
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatcoversationDropdown2">
                <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video me-2 fw-icon"></i>Video call</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2 fw-icon"></i>Audio call</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2 fw-icon"></i>Delete </a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-square-text me-2 fw-icon"></i>Mark as unread</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-volume-up me-2 fw-icon"></i>Muted</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2 fw-icon"></i>Archive</a></li>
                <li class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2 fw-icon"></i>Report</a></li>
              </ul>
            </div>
            <!-- Card action END -->
            <a class="btn btn-secondary-soft-hover py-1 px-2" data-bs-toggle="collapse" href="#collapseChat2" role="button" aria-expanded="false" aria-controls="collapseChat2"><i class="bi bi-dash-lg"></i></a>        
            <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <!-- Top avatar and status END -->
          
        </div>
        <div class="toast-body collapse show" id="collapseChat2">
          <!-- Chat conversation START -->
          <div class="chat-conversation-content custom-scrollbar h-200px">
            <!-- Chat time -->
            <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Applauded no discovery😊</div>
                    <div class="small my-2">6:15 AM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message right -->
            <div class="d-flex justify-content-end text-end mb-1">
              <div class="w-100">
                <div class="d-flex flex-column align-items-end">
                  <div class="bg-primary text-white p-2 px-3 rounded-2">With pleasure</div>
                </div>
              </div>
            </div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Please find the attached</div>
                    <!-- Files START -->
                    <!-- Files END -->
                    <div class="small my-2">12:16 PM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message left -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-2 px-3 rounded-2">How promotion excellent curiosity😮</div>
                    <div class="small my-2">3:22 PM</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat message right -->
            <div class="d-flex justify-content-end text-end mb-1">
              <div class="w-100">
                <div class="d-flex flex-column align-items-end">
                  <div class="bg-primary text-white p-2 px-3 rounded-2">And sir dare view.</div>
                  <!-- Images -->
                  <div class="d-flex my-2">
                    <div class="small text-secondary">5:35 PM</div>
                    <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Chat time -->
            <div class="text-center small my-2">2 New Messages</div>
            <!-- Chat Typing -->
            <div class="d-flex mb-1">
              <div class="flex-shrink-0 avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
              </div>
              <div class="flex-grow-1">
                <div class="w-100">
                  <div class="d-flex flex-column align-items-start">
                    <div class="bg-light text-secondary p-3 rounded-2">
                      <div class="typing d-flex align-items-center">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Chat conversation END -->
          <!-- Chat bottom START -->
          <div class="mt-2">
            <!-- Chat textarea -->
            <textarea class="form-control mb-sm-0 mb-3" placeholder="Type a message" rows="1"></textarea>
            <!-- Button -->
            <div class="d-sm-flex align-items-end mt-2">
              <button class="btn btn-sm btn-danger-soft me-2"><i class="fa-solid fa-face-smile fs-6"></i></button>
              <button class="btn btn-sm btn-secondary-soft me-2"><i class="fa-solid fa-paperclip fs-6"></i></button>
              <button class="btn btn-sm btn-success-soft me-2"> Gif </button>
              <button class="btn btn-sm btn-primary ms-auto"> Send </button>
            </div>
          </div>
          <!-- Chat bottom START -->
        </div>
      </div>
      <!-- Chat toast 2 END -->

    </div>
  </div>
  <!-- Chat END -->

</div>
  <!-- Show follower/following Main Chat END -->

<!-- Modal create Feed START -->
<div class="modal fade" id="modalCreateFeed" tabindex="-1" aria-labelledby="modalLabelCreateFeed" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal feed header START -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabelCreateFeed">Create post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal feed header END -->

      <!-- Modal feed body START -->
      <div class="modal-body">
          <!-- Add Feed -->
          <div class="d-flex mb-3">
          <!-- Avatar -->
          <div class="avatar avatar-xs me-2">
            <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
          </div>
          <!-- Feed box  -->
          <form class="w-100">
            <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="4" placeholder="Share your thoughts..." autofocus></textarea>
          </form>
        </div>
        <!-- Feed rect START -->
        <div class="hstack gap-2">
          <a class="icon-md bg-success bg-opacity-10 text-success rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Photo"> <i class="bi bi-image-fill"></i> </a>
          <a class="icon-md bg-info bg-opacity-10 text-info rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Video"> <i class="bi bi-camera-reels-fill"></i> </a>
          <a class="icon-md bg-danger bg-opacity-10 text-danger rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Events"> <i class="bi bi-calendar2-event-fill"></i> </a>
          <a class="icon-md bg-warning bg-opacity-10 text-warning rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Feeling/Activity"> <i class="bi bi-emoji-smile-fill"></i> </a>
          <a class="icon-md bg-light text-secondary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Check in"> <i class="bi bi-geo-alt-fill"></i> </a>
          <a class="icon-md bg-primary bg-opacity-10 text-primary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag people on top"> <i class="bi bi-tag-fill"></i> </a>
        </div>
        <!-- Feed rect END -->
      </div>
      <!-- Modal feed body END -->

      <!-- Modal feed footer -->
      <div class="modal-footer row justify-content-between">
        <!-- Select -->
        <div class="col-lg-3">
          <select class="form-select js-choice choice-select-text-none" data-position="top" data-search-enabled="false">
            <option value="PB">Public</option>
            <option value="PV">Friends</option>
            <option value="PV">Only me</option>
            <option value="PV">Custom</option>
          </select>
        <!-- Button -->
        </div>
        <div class="col-lg-8 text-sm-end">
          <button type="button" class="btn btn-danger-soft me-2"> <i class="bi bi-camera-video-fill pe-1"></i> Live video</button>
          <button type="button" class="btn btn-success-soft">Post</button>
        </div>
      </div>
      <!-- Modal feed footer -->

    </div>
  </div>
</div>
<!-- Modal create feed END -->

<!-- Modal create Feed video START -->
<div class="modal fade" id="feedActionVideo" tabindex="-1" aria-labelledby="feedActionVideoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal feed header START -->
      <div class="modal-header">
      <h5 class="modal-title" id="feedActionVideoLabel">Add post video</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <!-- Modal feed header END -->

      <!-- Modal feed body START -->
      <div class="modal-body">
        <!-- Add Feed -->
        <div class="d-flex mb-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
          <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
        </div>
        <!-- Feed box  -->
        <form class="w-100">
          <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Share your thoughts..."></textarea>
        </form>
      </div>

      <!-- Dropzone photo START -->
      <div>
        <label class="form-label">Upload attachment</label>
        <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
          <div class="dz-message">
            <i class="bi bi-camera-reels display-3"></i>
                <p>Drag here or click to upload video.</p>
          </div>
        </div>
      </div>
      <!-- Dropzone photo END -->

    </div>
      <!-- Modal feed body END -->

      <!-- Modal feed footer -->
      <div class="modal-footer">
        <!-- Button -->
        <button type="button" class="btn btn-danger-soft me-2"><i class="bi bi-camera-video-fill pe-1"></i> Live video</button>
        <button type="button" class="btn btn-success-soft">Post</button>
      </div>
      <!-- Modal feed footer -->
    </div>
  </div>
</div>
<!-- Modal create Feed video END -->
    
@endauth

@endsection    