<? get_header(); ?>
			<section class="about-comp container-fluid text-center ">
			<section class=" container ">
				<span class="h2">О компании</span>
				 <hr>
				<div class="row text-center">
				
					<div class="col-md-4 col-12">
                        <?php if (have_post()) : ?>
                        <?php while (have_post()) : the_post(); ?>
						<div class="row flex-column">
						
						<div class="col-12 name">Новости компании</div>
							<div class="col-12"><img src="img/nov.jpg" alt="" class="img-fluid"></div>
							<div class="col-12" style="padding-top: 10px;  text-align:justify;  font-size: 13px;">В начале августа прошло очередное онлайн-совещание с региональными представителями компании Сераджем в России. На совещании представили и тепло приветствовали двух новых региональных дистрибьюторов, которые будут курировать</div>
							
						</div>
                        
					</div>
					<?php endwhile; ?>
                    <div class="pagenavi"><?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?></div>
                    <?php else : ?>
                    <?php endif; ?>
					
					
						<div class="col-md-4 col-12">
						<div class="row flex-column">
						<div class="col-12 name">Правильный менеджмент</div>
							<div class="col-12"><img src="img/right_management.jpg"   width="200px"  alt="" class="img-fluid"></div>
 						</div>
					</div>
					
					
			 		
						<div class="col-md-4 col-12">
						<div class="row flex-column">
						<div class="col-12 name">Благотворительность</div>
							<div class="col-12"><img src="img/blag.jpg" alt="" class="img-fluid"></div>
 						</div>
					</div>
					
				</div>
				
				
			</section>	
			</section>	
			
					<section class="production container-fluid text-center ">
					<section class="container ">
				<span class="h2">Продукция</span> 
				 <hr>
				<div class="row text-center">
				
					<div class="col-md-4 col-12">
						<div class="row flex-column">
						
						<div class="col-12">Основная продукция</div>
							<div class="col-12"><img src="img/osn.png" alt="" class="img-fluid"></div>
							<div class="col-12 legend">
								Предлагаем ознакомиться с терапевтическими препаратами от компании Ceragem.
							</div>
							
						</div>
					</div>
					
					
					
						<div class="col-md-4 col-12">
						<div class="row flex-column">
						<div class="col-12">Тепловые маты</div>
							<div class="col-12"><img src="img/mat.png" alt="" class="img-fluid"></div>
								<div class="col-12 legend">
								Тепловые маты помогут восстановить прежнее здоровье.
							</div>
 						</div>
					</div>
					
					
			 		
						<div class="col-md-4 col-12">
						<div class="row flex-column">
						<div class="col-12">Дополнительная продукция</div>
							<div class="col-12"><img src="img/dop.png" alt="" class="img-fluid"></div>
								<div class="col-12 legend">
								Наши аксессуары помогут восстановить и сбалансировать жизненную энергию.
							</div>
 						</div>
					</div>
					
				</div>
				
				
			</section>
			</section>
<? get_footer(); ?>