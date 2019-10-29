<!DOCTYPE html>
<html>
	<head>
		<title>CRUD</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
	<br />
	
	<h3 align="center">CRUD</h3>
	<br />
	<div align="right" style="margin-bottom:5px;">
		<button type="button" name="add_button" id="add_button" class="btn btn-success btn-xs">Adicionar</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Nome</th>
		<th>Área</th>
		<th>Alterar</th>
		<th>Excluir</th>
		</tr>
		</thead>
		<tbody></tbody>
		</table>
	</div>
	</div>
	</body>
</html>

<div id="apicrudModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <form method="post" id="api_crud_form">
    <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Inserir Cadastro</h4>
         </div>
         <div class="modal-body">
          <div class="form-group">
            <label>Insira o Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" />
           </div>
           <div class="form-group">
            <label>Insira a Área</label>
            <input type="text" name="area" id="area" class="form-control" />
           </div>
       </div>
       <div class="modal-footer">
			<input type="hidden" name="hidden_id" id="hidden_id" />
			<input type="hidden" name="action" id="action" value="Inserir" />
			<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Inserir" />
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
   </form>
  </div>
   </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

 fetch_data();

 function fetch_data()
 {
  $.ajax({
   url:"fetch.php",
   success:function(data)
   {
    $('tbody').html(data);
   }
  })
 }

 $('#add_button').click(function(){
  $('#action').val('insert');
  $('#button_action').val('Inserir');
  $('.modal-title').text('Inserir');
  $('#apicrudModal').modal('show');
 });


 $('#api_crud_form').on('submit', function(event){
	event.preventDefault();
	if($('#nome').val() == '')
	{
	alert("Insira o Nome");
	}
	else if($('#area').val() == '')
	{
	alert("Insita a Área");
	}
	else
	{
	var form_data = $(this).serialize();
	$.ajax({
		url:"action.php",
		method:"POST",
		data:form_data,
		success:function(data)
		{
		fetch_data();
		$('#api_crud_form')[0].reset();
		$('#apicrudModal').modal('hide');
		if(data == 'insert')
		{
		alert("Dado Inserido!");
		}
		if(data == 'update')
		{
		alert("Dado Alterado!");
		}
		}
	});
	}
 });


$(document).on('click', '.edit', function(){
	var id = $(this).attr('id');
	var action = 'fetch_single';
	$.ajax({
		url:"action.php",
		method:"POST",
		data:{id:id, action:action},
		dataType:"json",
		success:function(data)
		{
			$('#hidden_id').val(id);
			$('#nome').val(data.nome);
			$('#area').val(data.area);
			$('#action').val('update');
			$('#button_action').val('Alterar');
			$('.modal-title').text('Alterar');
			$('#apicrudModal').modal('show')	;
		}
	})
 });
 
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id");
  var action = 'delete';
  if(confirm("Tem certeza que deseja deletar?"))
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{id:id, action:action},
    success:function(data)
    {
     fetch_data();
     alert("Dado deletado!");
    }
   });
  }
 });

});

</script>