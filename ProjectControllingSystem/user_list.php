<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Добавить нового пользователя</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">№</th>
						<th>Имя</th>
						<th>Почта</th>
						<th>Роль</th>
						<th>Действие</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array('',"Admin","Project Manager","Employee");
					$type_desc = array('',"Администратор","Преподаватель","Студент");
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users order by concat(firstname,' ',lastname) asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo $row['email'] ?></b></td>
						<td><b><?php echo $type_desc[$row['type']] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Действие
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Показать</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Редактировать</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Удалить</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable({
			"language": 
			{
				"sProcessing": "В обработке",
				"sLengthMenu": "Показать _MENU_",
				"sZeroRecords": "Нет записей",
				"sInfo": "Показано с _START_ до _END_ <br/> Всего записей _TOTAL_",
				"sInfoEmpty": "Пусто",
				"sInfoFiltered": "(Отфильтровать до _MAX_)",
				"sInfoPostFix": "",
				"sSearch": "Поиск:",
				"sUrl": "",
				"oPaginate": {
					"sFirst": "Первая",
					"sPrevious": "Предыдущая",
					"sNext": "Следующая",
					"sLast": "Последняя"
				}
			}
		});
	$('.view_user').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> Детали пользователя","view_user.php?id="+$(this).attr('data-id'))
	})
	$('.delete_user').click(function(){
	_conf("Вы действительно хотите удалить пользователя?","delete_user",[$(this).attr('data-id')])
	})
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Данные успешно удалены",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>