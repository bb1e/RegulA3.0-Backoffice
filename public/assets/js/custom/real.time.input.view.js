var descricao = document.getElementById('descricao');
                                    descricao.onkeyup = descricao.onkeypress = function(){
                                        document.getElementById('preview').innerHTML = this.value;
                                    }
