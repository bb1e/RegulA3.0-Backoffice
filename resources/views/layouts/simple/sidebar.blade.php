<div class="iconsidebar-menu">
   <div class="sidebar">
      <ul class="iconMenu-bar custom-scrollbar">
         <li>
            <a class="bar-icons" href="{{route('default')}}">
               <!--img(src='{{route('/')}}/assets/images/menu/home.png' alt='')--><i class="pe-7s-home"></i><span>Página principal</span>
            </a>

         </li>

         <li>
         <a class="bar-icons" href="{{route('criancas')}}">
         <i class="icofont icofont-autism"></i><span>Crianças</span>
            </a>
         </li>


         <li>
         <a class="bar-icons" href="{{route('estrategias')}}">
         <i class="pe-7s-note2"></i><span>Estratégias</span>
            </a>
         </li>

         <li>
         <a class="bar-icons" href="{{route('chat')}}">
         <i class="pe-7s-chat"></i><span>Chat</span>
            </a>
         </li>

         <li>
         <a class="bar-icons" href="{{route('forum')}}">
         <i class="icon-comments"></i><span>Fórum</span>
            </a>
         </li>

        @if (session()->get('admin_session')['tipo'] == 'A')
            <li>
            <a class="bar-icons" href="{{route('terapeutas')}}">
            <i class="icofont icofont-doctor"></i><span>Terapeutas</span>
               </a>
            </li>
        @endif


      </ul>
   </div>
</div>
