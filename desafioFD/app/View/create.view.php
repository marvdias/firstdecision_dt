<main class="form-signin">

      <div id="alert-message">
        <p id="mensagemErro"></p>
      </div>

  
    <h1 class="h3 mb-12 fw-normal">Cadastro de Usuário</h1>

    <div class="row">
      <label for="colFormLabel" class="col-sm-2 col-form-label">Nome</label>
      <div class="col-10">
        <input value="<?=old_value('name')?>" id="name" type="text" class="form-control" id="colFormLabel" placeholder="Nome">
      </div>
    </div>
    <div class="row">
      <label for="colFormLabel" class="col-sm-2 col-form-label">Email</label>
      <div class="col-10">
        <input value="<?=old_value('email')?>" id="email" type="email" class="form-control" id="colFormLabel" placeholder="email@email.com">
      </div>
    </div>
    <div class="row">
      <label for="colFormLabel" class="col-sm-2 col-form-label">Senha</label>
      <div class="col-10">
        <input id="password" type="password" class="form-control" id="colFormLabel" placeholder="Senha">
      </div>
    </div>
    <div class="row">
      <label for="colFormLabel" class="col-sm-2 col-form-label">Repetir Senha</label>
      <div class="col-10">
        <input id="password2" type="password" class="form-control" id="colFormLabel" placeholder="Repetir Senha">
      </div>
    </div>
    <div class="row-4">
    <button class="btn btn-primary" onclick="addUser();">Criar</button>
    </div>
</main>

<script src="<?=ROOT?>/assets/js/jquery.min.js"></script>
<script>
function addUser(){

  var name = $("#name").val();
  var email = $("#email").val();
  var password = $("#password").val();
  var password2 = $("#password2").val();

  $.post("<?=ROOT?>/user/register", {
      name:name,
      email:email,
      password:password,
      password2:password2
  })
  .done(function (resposta) {
    console.log(resposta);
    try {
      $( "#alert-message" ).removeClass('alert-danger').addClass("alert alert-success");
      $("#mensagemErro").html("Sucesso: Usuario cadastrado com sucesso");
      setTimeout(function(){
        window.location.href = "<?=ROOT?>/user/";
      }, 2000);
        
    } catch (e) {
        $("#mensagemErro").html("Erro desconhecido1.");
    }
              }) 
  .fail(function (xhr) {
    try {
      $( "#alert-message" ).addClass("alert alert-danger");
        var response = JSON.parse(xhr.responseText);
        $("#mensagemErro").html("Erro: " + response.message);
    } catch (e) {
        $("#mensagemErro").html("Erro desconhecido2.");
    }
  });
}
  </script>

