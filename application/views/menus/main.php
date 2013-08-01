<ul>
	<?php foreach ($this->menu_data as $menu_item):?>
	<li><a href="<?php echo base_url($menu_item['base']); ?>"><?php echo $menu_item['name']; ?>
	</a> <?php if(isset($menu_item['dropdown'])): ?>
		<ul>
			<?php foreach ($menu_item['dropdown'] as $dropdown_item): ?>
			<li><a href="<?php echo base_url($dropdown_item['base']); ?>"><?php echo $dropdown_item['name']; ?>
			</a>
			</li>
			<?php endforeach;?>
		</ul> <?php endif;?>
	</li>
	<?php endforeach; ?>
</ul>