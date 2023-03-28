@extends('layouts.simple.master')
@section('title', 'Chat App')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h2>Chat<span>App</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Apps</li>
<li class="breadcrumb-item">User</li>
<li class="breadcrumb-item active">Chat App</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="user-profile">
      <div class="row">
         <div class="col-sm-12">
            <div class="card hovercard text-center">
               <div class="info">
                  <div class="text-center">
                     <a href="{{ route('chat.encontrar') }}" class="btn btn-info btn-lg"><span class="icon-bar-chart"></span> Encontrar amigos</a>
                     <a href="{{ route('chat.pedidos') }}" class="btn btn-info btn-lg"><span class="icon-clipboard"></span> Ver pedidos pendentes</a>

                      <div id="error-div">
                         <br>
                         <br>
                         <div class="alert alert-danger">
                             <ul id="error-messages">
                                 {{--<li class="text-center">{{ $error }}</li>--}}
                             </ul>
                         </div>
                      </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col call-chat-sidebar col-sm-12">
         <div class="card">
            <div class="card-body chat-body">
               <div class="chat-box">
                  <!-- Chat left side Start-->
                  <div class="chat-left-aside">
                     <div class="media">
                        <img class="rounded-circle user-image" src="{{url(route('profilepic.print'))}}" alt="">

                        <div class="about">
                           <div class="name f-w-600">{{$user->data()['nome']}}</div>

                        </div>
                     </div>
                     <div class="people-list" id="people-list">
                        <div class="search">
                           <form class="theme-form">
                              <div class="form-group">
                                 <input class="form-control" type="text" placeholder="search"><i class="fa fa-search"></i>
                              </div>
                           </form>
                        </div>
                        <ul class="list">
                        @if(!empty($contacts))
                        @foreach ($contacts as $contact)
                        <a href="{{ route('chatRecreate', $contact['uid']) }}">
                        <li class="clearfix">
                              <img class="rounded-circle user-image" src="{{route('/')}}/img/{{$contact['imageName']}}" alt="">
                              <div class="status-circle away"></div>
                              <div class="about">
                                 <div class="name">{{$contact['name']}}</div>
                                 <!--<div class="status">Hello Name</div>-->
                              </div>
                        </li>
                        </a>
                        @endforeach
                        @endif
                        </ul>
                     </div>
                  </div>
                  <!-- Chat left side Ends-->
               </div>
            </div>
         </div>
      </div>
      <div class="col call-chat-body">
         <div class="card">
            <div class="card-body p-0">
               <div class="row chat-box">
                  <!-- Chat right side start-->
                  <div class="col pr-0 chat-right-aside">
                     <!-- chat start-->
                     @isset($sender)
                     <div class="chat">
                        <!-- chat-header start-->
                        <div class="chat-header clearfix">
                           <img class="rounded-circle" src="{{route('/')}}/img/{{$contact['imageName']}}" alt="">
                           <div class="about">
                              <div class="name">{{$sender['name']}}<span class="font-primary f-12"></span></div>

                           </div>
                        </div>
                        <!-- chat-header end-->
                        <div class="chat-history chat-msg-box custom-scrollbar" id="historico">
                           <ul id="mensagens">
                  </ul>
               </div>
               <!-- end chat-history-->

                  <div class="chat-message clearfix">
                     <div class="row">

                        <div class="col-xl-12 d-flex">
                           <div class="smiley-box bg-primary">
                                <label for="file-upload">
                                    <i class="icon-clip"></i>
                                    <input id="file-upload" class="p-0" name="file-upload" type="file" accept="image/jpeg, image/png, application/pdf" style="display:none"/>
                                </label>
                           </div>

                           <div class="input-group text-box">
                                 <input class="form-control input-txt-bx" id="message-to-send" type="text" name="message" placeholder="Escreva uma mensagem......">
                                 <div class="input-group-append">
                                    <button class="btn btn-primary" id="btn-enviar">Enviar</button>
                                 </div>
                           </div>
                        </div>
                     </div>
                  </div>
               <!-- end chat-message-->
               <!-- chat end-->
               <!-- Chat right side ends-->
            </div>
            @endif
         </div>

      </div>
   </div>
</div>
</div>
</div>
</div>
@endsection

@section('script')
<script src="{{route('/')}}/assets/js/fullscreen.js"></script>
<script src="https://momentjs.com/downloads/moment.min.js"></script>

<script type="module">
    <?php if(!isset($sender)){ $sender = ['uid' => "",]; }?>

    import 'https://www.gstatic.com/firebasejs/9.9.0/firebase-app.js'

    import {getAnalytics} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-analytics.js'
    import {getDatabase,child,set,get,update,push,ref,onValue,onChildAdded,onChildRemoved,onChildChanged} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-database.js'
    import {getStorage,getDownloadURL,uploadBytes,ref as sref} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-storage.js'
    import {getAuth,onAuthStateChanged,signInWithCustomToken} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-auth.js'
    import {getFirestore} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-firestore.js'
    import {initializeApp} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-app.js'

    var senderJson = @json($sender);

    var user = @json($user->data());

    const config = {
        apiKey: "AIzaSyBlizQNXAj9_zfTboEoek_qzulJQ4vnEBY",
        authDomain: "regula-9d0d3.firebaseapp.com",
        databaseURL: "https://regula-9d0d3-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "regula-9d0d3",
        storageBucket: "regula-9d0d3.appspot.com",
        messagingSenderId: "673196519117",
        appId: "1:673196519117:web:6c09bff6c1b9360a1a8384",
        measurementId: "G-T9LGMCNGC7"
    };

    const app = initializeApp(config);

    const auth = getAuth()

    /*onAuthStateChanged(auth, user => {
        console.log("auth: " + JSON.stringify(user,null,2))
    });*/

    let messageInput = null;
    let fileInput = null;
    let btnEnviar = null;
    const errorDoc = document.getElementById('error-messages')
    const errorDiv = document.getElementById('error-div')



    const errorEmpty = 'É necessário enviar um mensagem ou ficheiro'
    const errorInvalidFormat = 'Apenas são suportados ficheiros do tipo jpg, png e pdf.'

    const addErrorMessage = msg => {
        $(errorDiv).find('*').show()
        const newLi = document.createElement('li', {})
        newLi.className = "text-center"
        newLi.innerText = msg
        errorDoc.appendChild(newLi);
    }

    const removeErrors = () => {
        $(errorDiv).find('*').hide()
        errorDoc.innerHTML = ''
    }

    const getExtension = name =>  name.split('.').pop()

    removeErrors()

    let msgRef = null
    let messages = []
    let msgInverseRef = null
    let db = null
    let storage = null

    signInWithCustomToken(auth, "{{$customToken}}")
	.then((userCredential) => {
	    // Signed in
	    console.log("logged in!");

	    if (senderJson["uid"] != ""){
		db = getDatabase()
		storage = getStorage()

		messageInput = document.getElementById("message-to-send");
		fileInput = document.getElementById("file-upload");
		btnEnviar = document.getElementById('btn-enviar');

		messageInput.value = ""
		fileInput.value = ""

		removeErrors()

		msgRef = ref(db,`Messages/{{$user['id']}}/{{$sender['uid']}}`)
		msgInverseRef = ref(db,`Messages/{{$sender['uid']}}/{{$user['id']}}`)


		onChildAdded(msgRef,data => {
		    messages.push(data.val())
		    $('#mensagens').append(messageComponent(data.val()))

		    updateScroll()
		})

		onChildChanged(msgRef,data => {
		    const ind = messages.findIndex(val => val.messageID = data.val().messageID)

		    if(ind <= -1){
			return
		    }

		    messages[ind] = data.val()

		    $(`#${data.val().messageID}`).html(messageComponent(data.val()))
		})

		onChildRemoved(msgRef,data => {
		    const ind = messages.findIndex(val => val.messageID = data.val().messageID)

		    if(ind <= -1){
			return
		    }

		    messages.splice(ind,1)
		    $(`#${data.val().messageID}`).remove()
		})
	    }

	    btnEnviar?.addEventListener('click',ev => {
		ev.preventDefault()

		removeErrors()

		if(!messageInput.value && !fileInput.value){
		    addErrorMessage(errorEmpty)
		    return
		}

		if(!!fileInput.value && !['jpg','pdf','png'].includes(getExtension(fileInput.value))){
		    addErrorMessage(errorInvalidFormat)
		    return
		}

		let fileContents = null;
		let downloadURL = null;

		const fileExt = getExtension(fileInput.value)

		const type = messageInput.value ? "text": fileExt == 'pdf' ? 'pdf' : "image";

		const from = "{{$user['id']}}";
		const to = "{{$sender['uid']}}";

		const newkey = push(ref(db,`Messages/${from}/${to}`)).key

		function sendMessageDatabase(url) {

		    const updateObj = {
			from,
			to,
			type,
			messageID: newkey,
			date: moment().format('DD/MM/YYYY'),
			time: moment().format('H:m:s'),
			message: type == "text" ? messageInput.value : url
		    }

		    messageInput.value = ""

		    set(ref(db, `Messages/${from}/${to}/${newkey}`), updateObj)
			.then(() => console.log("success!"))
			.catch(err => console.log("failure! " + err));

		    set(ref(db, `Messages/${to}/${from}/${newkey}`), updateObj)
			.then(() => console.log("success!"))
			.catch(err => console.log("failure! " + err));
		}

		if(type != "text"){
		    let imageRef = null

		    switch(fileExt){
			case "pdf":
			    imageRef = `Document Files/${newkey}.pdf`
			    break;
			case "jpeg":
			case "jpg":
			case "png":
			    imageRef = `Image Files/${newkey}.${fileExt}`
			    break;
			default:
			    console.error("invalid file extension " + fileExt)
			    return;
		    }

		    const storageRef = sref(storage,imageRef)
		    uploadBytes(storageRef,fileInput.files[0])
			.then(res => {
			    console.log("upload success!")

			    getDownloadURL(res.ref)
				   .then(sendMessageDatabase)
			})
			.catch(err => console.log("failure! " + err));
		}
		else {
		    sendMessageDatabase()
		}

	    })
	})
	.catch((error) => {
	    const errorCode = error.code;
	    const errorMessage = error.message;
	    addErrorMessage("Erro ao conectar ao chat, por favor recarregue a página.")
	});



    function messageComponent(message){
        const dateCondition = new Date(Date.now() - 24 * 3600 * 1000) < moment(message.date,"DD/MM/YYYY").toDate();

        return message.from == user.id ?
                (message.type == "text" ? `
                    <li class="clearfix" id="${message.messageID}">
                        <div class="message other-message pull-right text-right">
                    ${dateCondition ? `
                        <div class="message-data text-right"><span class="message-data-time">${message.time}</span>
                        </div>
                        ` : `
                        <div class="message-data text-right"><span
                            class="message-data-time">${message.time} de ${message.date}</span></div>
                        `
                    }
                            ${message.message}
                        </div>
                    </li>
                `
                : message.type == "image" ? `
                    <li class="clearfix" id="${message.messageID}">
                        <div class="message other-message pull-right text-right">
                        ${dateCondition ? `
                            <div class="message-data text-right"><span class="message-data-time">${message.time}</span></div>
                        ` : `
                            <div class="message-data text-right"><span class="message-data-time">${message.time} de ${message.date}</span></div>
                        `}
                        <img src="${message.message}" class="css-class" alt="alt text" style="width:200px;height:200px;">
                         </div>
                     </li>
                 `
                : `
                    <li class="clearfix" id="${message.messageID}">
                        <div class="message other-message pull-right text-right">
                        ${dateCondition ? `
                            <div class="message-data"><span class="message-data-time">${message.time}</span>
                            </div>
                         ` : `
                        <div class="message-data"><span class="message-data-time">${message.time} de ${message.date}</span></div>
                         `}
                        <a href="${window.location.origin}/chat/download/${message.messageID}"><img src="../assets/images/default/file.png" style="width:42px;height:42px;"></a>
                         </div>
                     </li>
                `)
            :
                (message.type == "text" ? `
                    <li id="${message.messageID}">
                        <div class="message my-message text-left">

                        ${dateCondition ? `
                            <div class="message-data text-right"><span class="message-data-time">${message.time}</span></div>
                        ` : `
                            <div class="message-data text-right"><span class="message-data-time">${message.time} de ${message.date}</span></div>
                        `}
                        ${message.message}
                        </div>
                    </li>
                `
                : message.type == "image" ? `
                    <li id="${message.messageID}">
                        <div class="message my-message text-left">

                    ${dateCondition ? `
                        <div class="message-data text-right"><span class="message-data-time">${message.time}</span>
                        </div>
                    ` : `
                        <div class="message-data text-right"><span class="message-data-time">${message.time} de ${message.date}</span></div>
                    `}

                        <img src=${message.message} class="css-class" alt="alt text" style="width:200px;height:200px;">
                        </div>
                         </li>
                 `
                : `
                <li id="${message.messageID}">
                    <div class="message my-message text-left">

                    ${dateCondition ? `
                        <div class="message-data text-right"><span class="message-data-time">${message.time}</span>
                        </div>
                    ` : `
                        <div class="message-data text-right"><span class="message-data-time">${message.time} de ${message.date}</span></div>
                    `}
                    <a href="${window.location.origin}/chat/download/${message.messageID}"><img src="../assets/images/default/file.png" style="width:42px;height:42px;"></a>
                    </div>
                </li>
                `)
    }


    fileInput?.addEventListener('change', function () {
        if(this.value == null || this.value == ""){
            messageInput.disabled = false;
            messageInput.placeholder = 'Escreva uma mensagem...';
        }else{
            messageInput.disabled = true;
            messageInput.placeholder = "Ficheiro selecionado: " + this.value;
            messageInput.value = "";
        }
    });

    function updateScroll(){
        var myDiv = document.getElementById("historico");
        myDiv.scrollTop = myDiv.scrollHeight;
    }
</script>
@endsection
