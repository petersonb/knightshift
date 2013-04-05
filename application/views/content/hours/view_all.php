<input type="hidden" id="x" value="1" />
<h1>View All Hours</h1>
<?php $sortCol=0; ?>
<table class="dataTable" id="dataTable">
	<thead>
		<tr>
			<?php if (!$this->department_context && !$this->department_id):?>
			<?php $sortCol++; ?>
			<th>Department</th>
			<?php endif; ?>
			
			<?php if (!$this->employee_id): ?>
			<?php $sortCol++; ?>
			<th>Employee</th>
			<?php endif; ?>
			
			<th>Date</th>
			<th>Time In</th>
			<th>Time Out</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<input type="hidden" value="<?php echo $sortCol; ?>" id="sortCol"/>