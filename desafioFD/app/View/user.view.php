<h1 class="h3 mb-12 fw-normal">Lista de Usuários</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nome</th>
      <th scope="col">Email</th>
      <th scope="col">Senha</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($users as $user):
    ?>
      <tr>
        <th scope="row"><?=$user->id?></th>
        <td><?=$user->name?></td>
        <td><?=$user->email?></td>
        <td><?=$user->password?></td>
      </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>