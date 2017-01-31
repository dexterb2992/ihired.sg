<div id="menu">
	

    <ul class="menu">
        <li><a href="<?php echo base_url("dashboard/index"); ?>" class="parent"><span><img class="home-icon" src="<?php asset_url("dashboard/images/home-btn.png"); ?>" height="15" width="15"/></span></a></li>      
          <?php if (@$this->top_modules) { foreach($this->top_modules as $module): ?>
			<li>
				<a href="<?php echo !empty($module['uri']) ? base_url($module['uri']) : "#"; ?>">
					<span>
						<?php echo $module['label']; ?>
					</span>
					<?php if(!empty($module['sub_modules'])): ?>
						<ul>
						<?php foreach($module['sub_modules'] as $sub_module): ?>
							<li>
								<a href="<?php echo !empty($sub_module['uri']) ? base_url($sub_module['uri']) : "#"; ?>"><span><?php echo $sub_module['label']; ?></span></a>
							</li>
						<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; } ?>    
    </ul>
</div>

<div id="copyright">Copyright &copy; 2013 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>