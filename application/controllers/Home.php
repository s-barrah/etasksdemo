<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	protected $jsonFile = './uploads/files/json/data.json';
	
	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		//assign page title name
		$data['pageTitle'] = 'Home Page';
			
		//assign page ID
		$data['pageID'] = 'home';
			
		//assign page header	
		$this->load->view('pages/header', $data);
			
		//assign page title name
		$this->load->view('pages/home_page', $data);
			
		//assign page footer
		$this->load->view('pages/footer', $data);
	}
		 
	public function tasks()
	{
		
		//JSON file
		$file = $this->jsonFile;
		
		// put the contents of the file into a variable
		//Get data from existing json file
		$jsondata = file_get_contents($file); 
		
		// decode the JSON feed
		// converts json data into array
		$data['tasks'] = json_decode($jsondata, true); 
		
		//assign page title name
		$data['pageTitle'] = 'Tasks';
			
		//assign page ID
		$data['pageID'] = 'tasks';
			
		//assign page header	
		$this->load->view('pages/header', $data);
			
		//assign page title name
		$this->load->view('pages/tasks_page', $data);
			
		//assign page footer
		$this->load->view('pages/footer', $data);
	}
	
	/**
	* Function to validate add task
	*
	*/			
	public function add_task(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('task_name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('task_description','Task Description','required|trim|xss_clean');
		$this->form_validation->set_rules('task_completed','Task Completed','required|trim|xss_clean');
		$this->form_validation->set_rules('date_due','Date Due','required|trim|xss_clean');
		$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
		
		$this->form_validation->set_message('required', '%s cannot be blank!');
		//$this->form_validation->set_message('is_unique', 'This task already exists!');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
		if($this->form_validation->run()){
							
			//JSON file
			$jsonFile = $this->jsonFile;
			
			// create empty array
			$arr_data = array(); 
			
			// put the contents of the file into a variable
			//Get data from existing json file
			$jsondata = file_get_contents($jsonFile); 
		
			// decode the JSON feed
			// converts json data into array
			$arr_data = json_decode($jsondata, true);
			
			//count array
			$count = count($arr_data);
			
			//new task id
			$new_id = $count + 1;
			
			//CONVERT DATE FORMAT
			$date_due = $this->input->post('date_due');   
			$date_due = date('Y-m-d H:i:s', strtotime($date_due));
			$date_due_micro = strtotime($date_due) * 1000;
			
			//
			$completed = $this->input->post('task_completed');
			$completed = ($completed == 'true' ? true : false);
			
			//Store data posted from form in an array
			$formdata = array(
				'id' => $new_id,
				'name' => $this->input->post('task_name'),
				'description' => $this->input->post('task_description'),
				'completed' => $completed,
				'date_created' => round(microtime(true) * 1000),
				'date_due' => $date_due_micro,
				'category' => $this->input->post('category'),
			);
			
			// Push new form data to array
			array_push($arr_data, $formdata);

			//Convert updated array to JSON
			$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
		   
			//write json data into json file
			if(file_put_contents($jsonFile, $jsondata)) {
				$inserted = true;
			}else{
				$inserted = false;
			}
			//save to db
			//$inserted = $this->Tasks->insert_task($formdata);
							
			if($inserted){
					
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Task has been added!</div>';
							
			}else{
			
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Task has not been added!</div>';
							
			}				
		}
		else {
						
			$data['success'] = false;
			$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				
		}

		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);			
	}


			
	/**
	* Function to validate update task
	* form
	*/			
	public function update_task(){
			
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
		$this->form_validation->set_rules('task_name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('task_description','Task Description','required|trim|xss_clean');
		$this->form_validation->set_rules('task_completed','Task Completed','required|trim|xss_clean');
		$this->form_validation->set_rules('date_due','Date Due','required|trim|xss_clean');
		$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
				
		if ($this->form_validation->run()){
			
			//escaping the post values
			$task_id = html_escape($this->input->post('task_id'));
			$id = preg_replace('#[^0-9]#i', '', $task_id); // filter everything but numbers
							
			//JSON file
			$jsonFile = $this->jsonFile;
			
			// put the contents of the file into a variable
			//Get data from existing json file
			$jsondata = file_get_contents($jsonFile); 
		
			// decode the JSON feed
			// converts json data into array
			$arr_data = json_decode($jsondata, true);
			
			// Edit data if key matches
			foreach ($arr_data as $key => $value) {
				if ($value['id'] == $id) {
					
					//CONVERT FORMAT
					$date_due = $this->input->post('date_due');   
					$date_due = date('Y-m-d H:i:s', strtotime($date_due));
					$date_due = strtotime($date_due) * 1000;
					
					//
					$completed = $this->input->post('task_completed');
					$completed = ($completed == 'true' ? true : false);
					
					$arr_data[$key]['name'] = $this->input->post('task_name');
					$arr_data[$key]['description'] = $this->input->post('task_description');
					$arr_data[$key]['completed'] = $completed;
					$arr_data[$key]['date_due'] = $date_due;
					$arr_data[$key]['category'] = $this->input->post('category');
					
				}
			}
			
			//Convert updated array to JSON
			$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
		   
			//write json data into json file
			if(file_put_contents($jsonFile, $jsondata)) {
				$updated = true;
			}else{
				$updated = false;
			}
			
			//update in database
			//$updated = $this->Tasks->update_task($update, $id);
					
			if ($updated){	
				
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Task has been updated!</div>';
			}else{
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Task not updated!</div>';
			}	
		}else {
				
			$data['success'] = false;
			$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
		}
			
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);			
	}			
	
			
	/**
	* Function to remove task
	* 
	*/			
	public function remove_task(){

		if ($this->input->post('rID')){
			
			//escaping the post values
			$task_id = html_escape($this->input->post('rID'));
			$id = preg_replace('#[^0-9]#i', '', $task_id); // filter everything but numbers
							
			//JSON file
			$jsonFile = $this->jsonFile;
			
			// put the contents of the file into a variable
			//Get data from existing json file
			$jsondata = file_get_contents($jsonFile); 
		
			// decode the JSON feed
			// converts json data into array
			$arr_data = json_decode($jsondata, true);
			
			$deleted = false;
			
			// get array index to delete if key matches
			$arr_index = array();
			foreach ($arr_data as $key => $value) {
				if ($value['id'] == $id) {
					$arr_index[] = $key;
				}
			}
			
			// delete data
			foreach ($arr_index as $i)
			{
				unset($arr_data[$i]);
				$deleted = true;
			}

			// rebase array
			$arr_data = array_values($arr_data);

			//Convert updated array to JSON
			$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
		   
			//write json data into json file
			file_put_contents($jsonFile, $jsondata);
			
			//***********DELETE FROM DATABASE*********
			//load model
			//$tasks = new Tasks_model();
			//$tasks->load($id);
			//$tasks->delete();
					
			if ($deleted){	
				
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Task has been removed!</div>';
			}else{
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Task not removed!</div>';
			}	
		}else {
			$data['success'] = false;
			$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Server Error!</div>';
		}
			
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);			
	}			
	
	/**
	* Function to handle
	* marking tasks as
	* completed
	*/			
	public function mark_as_completed(){
		
		if ($this->input->post('cID')){
			
			//escaping the post values
			$task_id = html_escape($this->input->post('cID'));
			$id = preg_replace('#[^0-9]#i', '', $task_id); // filter everything but numbers
							
			//JSON file
			$jsonFile = $this->jsonFile;
			
			// put the contents of the file into a variable
			//Get data from existing json file
			$jsondata = file_get_contents($jsonFile); 
		
			// decode the JSON feed
			// converts json data into array
			$arr_data = json_decode($jsondata, true);
			
			// Edit data if key matches
			foreach ($arr_data as $key => $value) {
				if ($value['id'] == $id) {
					
					$arr_data[$key]['completed'] = true;
					
				}
			}
			
			//Convert updated array to JSON
			$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
		   
			//write json data into json file
			if(file_put_contents($jsonFile, $jsondata)) {
				$updated = true;
			}else{
				$updated = false;
			}
			
			//update in database
			//$updated = $this->Tasks->update_task($update, $id);
					
			if ($updated){	
				
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Task has been marked as completed!</div>';
			}else{
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Task not marked as completed!</div>';
			}	
		}else{
			
			$data['success'] = false;
			$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Server Error!</div>';
		}
		
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);			
	}			
			

	
		/**
		* Function to handle
		* tasks view and edit
		* display
		*/	
		public function task_detail(){
			
			//Check that ID is not empty
			if($this->input->post('id')){
				
				//escaping the post values
				$task_id = html_escape($this->input->post('id'));
				$id = preg_replace('#[^0-9]#i', '', $task_id); // filter everything but numbers
			
				//JSON file
				$jsonFile = $this->jsonFile;
				
				// put the contents of the file into a variable
				//Get data from existing json file
				$jsondata = file_get_contents($jsonFile); 
			
				// decode the JSON feed
				// converts json data into array
				$arr_data = json_decode($jsondata, true);
				
				//Initialise Variables
				$wasFound = false;
				$tid = '';
				$name = '';
				$description = '';
				$completed = '';
				$date_created = '';
				$date_due = '';		
				$edit_date_due = '';
				$category = '';
			
				// Edit data if key matches
				foreach ($arr_data as $key => $value) {
					if ($value['id'] == $id) {
						
						$tid = $value['id'];
						$name = $value['name'];
						$description = $value['description'];
						//$completed = ($value['completed'] == 1 ? true : false);
						$completed = ($value['completed'] == 1 ? "true" : "false");
						$date_created = date("F j, Y, g:i a", $value['date_created'] / 1000);
						$date_due = date("F j, Y, g:i a", $value['date_due'] / 1000);
						
						$edit_date_due = date('Y-m-d g:i A', $value['date_due'] / 1000);
						$category = $value['category'];
			
						$wasFound = true;
						
					}
				}
				
				if($wasFound){
					
					$data['id'] = $tid;
					$data['name'] = $name;
					$data['description'] = $description;
					$data['completed'] = $completed;
					$data['date_created'] = $date_created;
					$data['date_due'] = $date_due;
							
					$data['edit_date_due'] = $edit_date_due;
					$data['category'] = $category;
					$data['edit_url'] = 'home/update_task';
					
					$data['success'] = true;
				}else{
					$data['success'] = false;
				}
				
								
			}

			echo json_encode($data);
		}					
		
	
	
}
