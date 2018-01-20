
	<!-- .container -->
	<div class="container">
		<h1><?php echo $pageTitle; ?></h1>

		<p><a class="btn btn-primary add_task_btn" href="#" data-toggle="modal" data-target="#taskModal" title="Add Task"><i class="fa fa-plus"></i> Add Task</a></p>
		
		
		
		<!-- .nav-tabs-custom -->
		<div class="nav-tabs-custom">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4>Tasks Group 1</h4></a>
				</li>
				<li role="presentation">
					<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4>Tasks Group 2</h4></a>
				</li>						
			</ul>
			<!-- /Nav tabs -->
			
			<!-- Tab panes -->
			<div class="tab-content">		
				<!-- Tab1 -->
				<div role="tabpanel" class="tab-pane active" id="tab1">
					<br/>
					<div class="notif"></div>
					<br/>
					
					<!-- container -->
					<div class="container">
						<!-- table-responsive -->
						<div class="table-responsive" >
							<!--table -->
							<table id="list-table" frame="box" class="table table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Description</th>
										<th>Completed</th>
										<th>Created</th>
										<th>Due Date</th>
										<th>Category</th>
										<th>View</th>
										<th>Edit</th>
										<th>Remove</th>
										<th>Mark as completed</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if($tasks){
									$id = 1;
									//print_r($tasks);
									
									foreach($tasks as $task){
										$url = 'home/task_detail';
										
										
								?>
									<tr>
										<td>
										<?php echo $task["id"]; ?></td>
										<td>
										<a href="#!" data-toggle="modal" data-target="#viewModal" title="View" onclick="viewTask(<?php echo $task["id"]; ?>,'<?php echo $url; ?>')"><?php echo $task["name"]; ?></a>
										</td>
										
										<td><?php echo $task["description"]; ?></td>
										<td>
										<?php 
										echo ($task["completed"] == 1 ? 'Yes' : 'No');
										
										?>
										</td>
										<td><?php echo date("F j, Y, g:i a", $task["date_created"] / 1000); ?></td>
										<td><?php echo date("F j, Y, g:i a", $task["date_due"] / 1000); ?></td>
										<td><?php echo $task["category"]; ?></td>
										
										<td>
										<a data-toggle="modal" data-target="#viewModal" class="btn btn-default btn-xs"  title="View" onclick="viewTask(<?php echo $task["id"]; ?>,'<?php echo $url; ?>')"><i class="fa fa-search"></i></a>
										</td>
										
										<td>
										<a data-toggle="modal" data-target="#taskModal" class="btn btn-primary btn-xs" title="Edit" onclick="editTask(<?php echo $task["id"]; ?>,'<?php echo $url; ?>')"><i class="fa fa-pencil"></i></a>
										</td>
										
										<td>
										<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#removeModal" title="Remove" onclick="confirmRemoval(<?php echo $task["id"]; ?>,'<?php echo $url; ?>')"><i class="fa fa-trash-o"></i></button>
										</td>
										
										<td>
										<?php
										if($task["completed"] != 1){
										?>
										<a data-toggle="modal" data-target="#completedModal" class="btn btn-success btn-xs" onclick="confirmCompleted(<?php echo $task["id"]; ?>,'<?php echo $url; ?>');" title="Mark as completed"><i class="fa fa-check-circle"></i></a>
										<?php
										}
										?>
										</td>
									</tr>
								<?php
										$id++;
									}
								}else{
								?>
									<tr>
										<td colspan="11">No tasks listed yet!</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
							<!-- /table -->
						</div>	
						<!-- /table-responsive -->
					</div>	
					<!-- /container -->	
				</div>
				<!-- Tab1 -->
								
				<!-- Tab2 -->
				<div role="tabpanel" class="tab-pane" id="tab2">
				<br/>
				</div>
				<!-- Tab2 -->
			</div>
			<!-- /Tab panes -->
		</div>
		<!-- /.nav-tabs-custom -->
	</div>	
	<!-- /.container -->

	
	
	<!-- ADD / EDIT TASK MODAL-->
	<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Task</h3>
				</div>
				<div class="modal-body">
					<div class="form_errors"></div>
						
					<form action="<?php echo base_url('home/add_task'); ?>" id="taskForm" name="taskForm" class="form-horizontal" method="post" enctype="multipart/form-data">
						
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="task_name">Name</label>
							<input type="text" class="form-control" name="task_name" id="task_name" placeholder="Task Name">
						</div>
					</div>
							
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="task_name">Description</label>
							<textarea class="form-control" name="task_description" id="task_description" placeholder="Task Description"></textarea>
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="task_completed">Task Completed?</label>
							<select class="form-control" name="task_completed" id="task_completed">
								<option value="">Select Status</option>
								<option value="true">Yes</option>
								<option value="false">No</option>
							</select>
							
						</div>
					</div>	

					
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="date_due">Date Due</label>
							<input type="text" class="form-control datetimepicker" name="date_due" id="date_due">
						</div>
					</div>
						
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="category">Category</label>
							<select class="form-control" name="category" id="category">
								<option value="">Select Category</option>
								<option value="Work">Work</option>
								
							</select>
							
						</div>
					</div>				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="task_id" id="taskID">
					<input type="hidden" id="updateURL">
					
					<button type="button" class="btn btn-success btn-add" onclick="javascript:addTask();">Add</button>	
					
					<button type="button" class="btn btn-primary btn-update hidden" onclick="javascript:updateTask();">Update Task</button>
				</div>
				</form>
			</div>
		</div>
	</div>	
	<!-- Add Task Modal-->
	
		
	
	<!-- View Task Modal-->
	<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="headerTitle" align="center"></h3>
				</div>
				<div class="modal-body">
					
					<p><b>Name</b></p>
					<p id="vTaskName"></p>
					
					<p><b>Description</b></p>
					<p id="vTaskDescription"></p>
					
					<p><b>Task Completed?</b></p>
					<p id="vTaskCompleted"></p>
					
					<p><b>Date Created</b></p>
					<p id="vCreated"></p>
					
					<p><b>Date Due</b></p>
					<p id="vDateDue"></p>
					
					<p><b>Category</b></p>
					<p id="vCategory"></p>
					
						
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				</div>
				
			</div>
		</div>
	</div>	
	<!-- View Task Modal-->
		
	
	<!-- Remove Task Modal-->
	<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Remove Task</h3>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url('home/remove_task'); ?>" id="removeTaskForm" name="removeTaskForm" class="form-horizontal" method="post" enctype="multipart/form-data">
					
					<p id="remove-error"></p>
					<p>Are you sure you wish to remove the task (<b><span id="rName"></span></b>)?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="rID" id="rID">
					<button type="button" class="btn btn-primary" onclick="javascript:removeTask();">Confirm</button>
				</div>
				</form>
			</div>
		</div>
	</div>	
	<!-- Remove Task Modal-->
		
	
	<!-- Mark Task as Completed Modal-->
	<div class="modal fade" id="completedModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Task Completed?</h3>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url('home/mark_as_completed'); ?>" id="completedTaskForm" name="completedTaskForm" class="form-horizontal" method="post" enctype="multipart/form-data">
					
					<p id="completed-error"></p>
					<p>Are you sure you wish to mark the task (<b><span id="cName"></span></b>) as completed?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="hidden" name="cID" id="cID">
					
					<button type="button" class="btn btn-primary" onclick="javascript:taskCompleted();">Confirm</button>
				</div>
				</form>
			</div>
		</div>
	</div>	
	<!-- Remove Task Modal-->
		
	
	