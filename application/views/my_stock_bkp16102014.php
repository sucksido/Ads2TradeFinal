<?php error_reporting(0);?>
<?php echo $map_1['js'];echo $map_3['js'];echo $map_5['js'];echo $map_7['js'];echo $map_9['js']; ?>
<?php echo $map_2['js'];echo $map_4['js'];echo $map_6['js'];echo $map_8['js'];echo $map_10['js']; ?>        


<div class="breadcrumbs">
    <h1><span class="glyphicon glyphicon-list-alt"></span>View Assets</h1>
</div>

    <h3>My Assets</h3>
    <div class="table_div">
    
  <table class="table table-bordered headed " width="100%" border="1" cellpadding="1"  cellspacing="1" bordercolor="#CCCCCC">
    <thead>
      <tr> 
        <th>Pic</th>
        <th><div align="center">Location</div></th>
        <th colspan="2"><div align="center">Details</div></th>
      </tr>
    </thead>
    <tbody>
      <?php
            $a = 0;
            foreach ($mmm as $row) {
              $a = $a + 1;
              $b = 'map_'.$a; 
              $c = 'map_canvas'.$a; 
			  
			$this->db->where('tow_id', $row->loc_id);
                        $select_query = $this->db->get('town');
			if ($select_query->num_rows > 0){
			foreach ($select_query->result() as $rows){
				$town=$rows->tow_description;
		}
		

		}
                
                $this->db->where('ass_id', $row->ass_id);
                  $select_query = $this->db->get('auctions');
			if ($select_query->num_rows > 0){
			foreach ($select_query->result() as $rows){
                            $found = 1;                        
				$towns=$rows->minimum_bid;
                                $from = $rows->starts;
                                $duration = $rows->duration;
                                $minimum_bid = $rows->minimum_bid;
                                $buy_now = $rows->buy_now;
                                $increment = $rows->increment;
                                }
		}else{
                                $towns='';
                                $from = '';
                                $duration = '';
                                $minimum_bid = '';
                                $buy_now = '';
                                $increment = '';   
                    
                }
			  
			  
			  
            ?>
      <tr> 
        <td width="70" height="70"> <div align="left"><a  href="asset?ass_id=<?php echo $row->ass_id;?>"> <img src="<?php echo $row->url;?>" width="95%" height="216%" align="left"> 
            </a> </div></td>
        <td width="284"> <p>Description :<?php echo $row->ass_description;?></p>
          <p>Location&nbsp&nbsp&nbsp&nbsp&nbsp:<?php echo $row->ass_address;?></p>
          
		   <p>Production Cost included :<?php ?></p></td>
        <td width="321"><p>Current Status :<?php ?></p>
          <p>Start Date &nbsp;&nbsp;&nbsp; <input type="text" name="start" value="<?php echo $from; ?>" ></p>
          <p>   <label for="dirst_name">Duration</label>                         
                <select name="duration" id="duration" >
                     <option value="0">Please Select Duration</option>
                    <?php
                    foreach ($durations as $row) {
                        echo "<option value=\"$row->days\" " . ((isset($_POST['days']) &&
                        $_POST['days'] == $row->tow_description) ? 'selected="selected"' : '') . " >$row->description</option>";
                    }
                    ?>
                    
                    
                </select></p>
</td>
      </tr>
      <?php }?>
    </tbody>
  </table>
    </div>

    </form>



</div><!--Main -->

<?php
//include("footer.php"); ?>