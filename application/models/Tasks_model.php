<?php

class Tasks_model extends MY_Model {
		
		var $table = 'tasks';
		
		var $column_order = array(null, 'name','description','completed','date_created','date_due','category'); //set column field database for datatable orderable
		
		var $column_search = array('name','description','completed','date_created','date_due','category'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
		

		const DB_TABLE = 'tasks';
		const DB_TABLE_PK = 'id';


		/**
		 * Task Name.
		 * @var string 
		 */
		public $name;

		/**
		 * Task Description.
		 * @var string 
		 */
		public $description;

		/**
		 * Task Completed Status.
		 * @var boolean
		 */
		public $completed;

		/**
		 * Task Date Created.
		 * @var datetime to microseconds 
		 */
		public $date_created;

		/**
		 * Task Date Due.
		 * @var datetime to microseconds 
		 */
		public $date_due;

		/**
		 * Task Category.
		 * @var string 
		 */
		public $category;

			
		private function _get_datatables_query()
		{
			 
			$this->db->from($this->table);
	 
			$i = 0;
		 
			foreach ($this->column_search as $item) // loop column 
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{
					 
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}
	 
					if(count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
			 
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		
		function get_datatables()
		{
			$this->_get_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_filtered()
		{
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_all()
		{
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}	
		
		
	
		/**
		* Function to insert task
		*  
		*/	
		public function insert_task($data){
			
			$query = $this->db->insert($this->table, $data);
			//$insert_id = $this->db->insert_id();
			if ($query){
				return true;
			}else {
				return false;
			}
				
		}
	
		/**
		* Function to update vehicle type
		* variable $id
		*/	
		public function update_task($data, $id){

			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

			
			
			
			
			


	
    
}

