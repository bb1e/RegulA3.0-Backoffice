<div class="page-main-header">
  <div class="main-header-right">
    <div class="main-header-left text-center">
      <div class="logo-wrapper"><a href="{{route('/')}}"><img src="{{route('/')}}/img/logo/logo1_resized2.png" alt=""></a></div>
    </div>
    <div class="mobile-sidebar">
      <div class="media-body text-right switch-sm">
        <label class="switch ml-3"><i class="font-primary" id="sidebar-toggle" data-feather="align-center"></i></label>
      </div>
    </div>
    <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar">               </i></div>
    <div class="nav-right col pull-right right-menu">
      <ul class="nav-menus">
        <li>
        </li>
        <li class="onhover-dropdown"><img class="img-fluid img-shadow-warning" src="{{route('/')}}/assets/images/dashboard/notification.png" alt="">
          <ul class="onhover-show-div notification-dropdown">
            <li class="gradient-primary">
              <h5 class="f-w-700">Notificações</h5><span>Há 6 mensagens não lidas</span>
            </li>
            <li>
              <div class="media">
                <div class="notification-icons bg-success mr-3"><i class="mt-0" data-feather="thumbs-up"></i></div>
                <div class="media-body">
                  <h6>Alguém deu like no teu post</h6>
                  <p class="mb-0"> 2 Horas atrás</p>
                </div>
              </div>
            </li>
            <li class="pt-0">
              <div class="media">
                <div class="notification-icons bg-info mr-3"><i class="mt-0" data-feather="message-circle"></i></div>
                <div class="media-body">
                  <h6>3 Comentários novos</h6>
                  <p class="mb-0"> 1 Hora atrás</p>
                </div>
              </div>
            </li>
            <li class="bg-light txt-dark"><a href="#">Todas </a> as Notificações</li>
          </ul>
        </li>
        <li class="onhover-dropdown"> <span class="media user-header"><img src="{{route('/')}}/img/terapeuta/{{ session()->get('admin_session')['imagem']}}" alt=""></span>
          <ul class="onhover-show-div profile-dropdown">
            <li class="gradient-primary">
              <h5 class="f-w-600 mb-0">{{ session()->get('admin_session')['nome']}}</h5>
                  @if (session()->get('admin_session')['tipo'] == 'T')
                    <span>Terapeuta</span>
                  @elseif (session()->get('admin_session')['tipo'] == 'A')
                    <span>Administrador</span>
                  @endif
            </li>

            <li><i data-feather="user"> </i><a style="color:black;" href="{{route('terapeuta.perfil')}}">Perfil</a></li>
            <li><i data-feather="edit"> </i><a onclick="logout()" style="color:black;" href="{{route('change.password')}}">Mudar password</a></li>

            <!-- <li><i data-feather="message-square"> </i>Caixa de entrada</li> -->
            <!-- <li><i data-feather="file-text"> </i>Lista de tarefas</li> -->
            <!-- <li><i data-feather="settings"> </i>Definições            </li> -->
            <li><i data-feather="log-out"> </i><a style="color:black;"  href="{{route('logout')}}">Logout</a></li>

          </ul>
        </li>
      </ul>
      <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
    </div>
    <script id="result-template" type="text/x-handlebars-template">
      <div class="ProfileCard u-cf">
      <div class="ProfileCard-avatar"><i class="pe-7s-home"></i></div>
      <div class="ProfileCard-details">
      <div class="ProfileCard-realName">name</div>
      </div>
      </div>
    </script>
    <script id="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
  </div>
</div>
