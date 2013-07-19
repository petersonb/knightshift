<input type="hidden" id="x" value="1" />
<h1>View All Admins</h1>
<?php $sortCol=0; ?>
<table class="dataTable" id="dataTable">
	<thead>
		<tr>
			<?php $sortCol++; ?>
			<th style="width: 200px;" >Firstname</th>
			<?php $sortCol++; ?>
			<th style="width: 250px;" >Lastname</th>
			<?php $sortCol++; ?>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<input
	type="hidden" value="<?php echo $sortCol; ?>" id="sortCol" />
