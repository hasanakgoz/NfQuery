<div class="row-fluid">
	<div class="span11">
		<?php
			DisplayDetails();
			#DisplayProcessing();
        ?>  
	</div>
</div>

<div class="row-fluid">
	<h3>Run Queries</h3>
	<div class="span5">
		<?php
			require_once('nfqueryutil.php');
			
			$subscripted = getSubscriptedSubscription();
			$squeries = getSubscriptionQueries($subscripted);
			echo '<div id="queryDiv">';
			if ($subscripted){
				echo '<div id="accordion" class="accordion">';
				foreach($subscripted as $s){
					echo '<div class="accordion-group">';
					echo '<div class="accordion-heading">';
					echo '<table><tr>';
					echo '<td><input type=checkbox class="markAllMandatory" name="'.$s.'"/></td>';
					echo '<td><a href="#'.$s.'" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">'.$s.' </a></td>';
					echo '</tr></table>';
					echo '</div>';
						echo '<div id="'.$s.'" class="accordion-body collapse in subscriptionBody">';
						echo '<div class="accordion-inner filters">';
					if ($squeries[$s]){
						foreach($squeries[$s] as $k1=>$package){	
							$has_query = false;
							foreach($package as $index=>$query){
							  if (strcmp($query['category_name'], 'mandatory') == 0){
								$has_query = true;
								echo '<input type=checkbox class="mandatory_filter" name="'.$query['query_id'].'">';
								echo '<span data-toggle="collapse" data-target="#optional'.$query['query_id'].'">'.$query['filter'].'</span></input>';
								echo '<div style="padding-left:20px; "id=optional'.$query['query_id'].' class="collapse in">';
							  }elseif(strcmp($query['category_name'], 'optional') == 0){
								echo '<input type=checkbox class="optional_filter" name="'.$query['query_id'].'">';
								echo '<span>"'.$query['filter'].'</span></input>';
								echo '<br>';
							  }
							}
							if ($has_query)
								echo '</div>';
						}
					}else{
						echo 'No queries found...';
					}
						echo '</div>';
						echo '</div>';
					echo '</div>';
			 	}
				echo '</div>';
			}else{
			}
			echo '</div>';
			echo '<a id="runQueries" class="btn btn-primary">Run !</a>'
		?>  
	</div>
	<div class="span3">
		<?php

			echo '<label>'.'Select Flow Source: '.'</label>';		
			echo '<select id="flowSource" multiple="multiple">';
			foreach($_SESSION['profileinfo']['channel'] as $channel=>$details){
				echo '<option>'.$channel.'</option>';
			}
			echo '</select>';
		?>
	</div>
</div>
