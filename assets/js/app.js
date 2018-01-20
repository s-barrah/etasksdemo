
$(document).ready(function() {
	
	//Date time picker
	$('.datetimepicker').datetimepicker();
	
	//Date picker
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});
	
	//CLEAR FORM ON BUTTON CLICK
    $('.add_task_btn').click(function(e) {
		
		$(".btn-add").removeClass('hidden');
		$(".btn-update").addClass('hidden');	
		
		//clear all fields
		$("#taskID").val('');
						
		$("#task_name").val('');
		$("#task_description").val('');
		$("#task_completed").val('');
		$("#date_due").val('');
		$("#category").val('');
		$("#updateURL").val('');
    });
	
	
	
});


//*****************START TASK FUNCTIONS*************//	
		 		
	//FUNCTION TO VIEW TASK DETAILS
	function viewTask(id, url) {
			
		//alert('ID: '+id);
		
		//CHECK IF EMPTY, DONT PROCEED
		if(id === '' || url === ''){
			$( "#load" ).hide();
			return;
		}	
			
		$( "#load" ).show();

		var dataString = { 
			id : id
		};	
		
		$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.name);
						
						$("#vTaskName").html(data.name);
						$("#vTaskDescription").html(data.description);
						$("#vTaskCompleted").html(data.completed);
						$("#vDateDue").html(data.date_due);
						$("#vCreated").html(data.date_created);
						$("#vCategory").html(data.category);
						
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//function to add new Task
		//via ajax
		function addTask() { 

			var form = new FormData(document.getElementById('taskForm'));
			
			var validate_url = $('#taskForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
						$("#taskModal").modal('hide');
						
						//clear all fields
						
						$("#task_name").val('');
						$("#task_description").val('');
						$("#task_completed").val('');
						$("#date_due").val('');
						$("#category").val('');
						$("#updateURL").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		
		//ajax function to edit Task details
		//
		function editTask(id, url){
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						$("#taskID").val(data.id);
						
						$("#task_name").val(data.name);
						$("#task_description").val(data.description);
						$("#task_completed").val(data.completed);
						$("#date_due").val(data.edit_date_due);
						$("#category").val(data.category);
						$("#updateURL").val(data.edit_url);
						$(".btn-add").addClass('hidden');
						$(".btn-update").removeClass('hidden');
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to submit edited details
		//to db via ajax
		function updateTask(){
			
			var form = new FormData(document.getElementById('taskForm'));
			
			//var validate_url = $('#taskForm').attr('action');
			var validate_url = $("#updateURL").val();
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#taskModal").modal('hide');
						
						//clear all fields
						$("#taskID").val('');
						
						$("#task_name").val('');
						$("#task_description").val('');
						$("#task_completed").val('');
						$("#date_due").val('');
						$("#category").val('');
						$("#updateURL").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					$(".form_errors").html(error);
				},
			});
						
		}
		
		//Ajax Function to confirm task removal
		//
		function confirmRemoval(id, url){
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						$("#rID").val(data.id);
						$("#rName").html(data.name);
						
					}else{
						$( "#load" ).hide();
						$("#remove-error").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//Ajax Function to Remove Task
		function removeTask(){
			
			var form = new FormData(document.getElementById('removeTaskForm'));
			
			var validate_url = $('#removeTaskForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#removeModal").modal('hide');
						
						//clear all fields
						$("#rID").val('');
						
						$("#rName").html('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#remove-error").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					$("#remove-error").html(error);
				},
			});
						
		}
		
		//Ajax Function to confirm task completion
		//
		function confirmCompleted(id, url){
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						$("#cID").val(data.id);
						$("#cName").html(data.name);
						
					}else{
						$( "#load" ).hide();
						$("#completed-error").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//Ajax Function to Mark Task as
		//Completed
		function taskCompleted(){
			
			var form = new FormData(document.getElementById('completedTaskForm'));
			
			var validate_url = $('#completedTaskForm').attr('action');
			
			alert('Hidden ID: '+ $("#cID").val());
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$("#load").hide();
						$("#completedModal").modal('hide');
						
						//clear all fields
						$("#cID").val('');
						$("#cName").html('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$("#load").hide();
						$("#completed-error").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					$("#completed-error").html(error);
				},
			});
						
		}

		
		//*****************END TASK FUNCTIONS*************//		
			