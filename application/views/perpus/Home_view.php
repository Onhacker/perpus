<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<h4 class="page-title"><?php echo $title ?></h4>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card-box">
				<div class="row">
					<div class="col-12">
						<h4 class=" m-t-0 header-title">Selamat di Sistem Informasi <?php echo $this->fm->web_me()->nama_website ?></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
								<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
								<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
							</ol>
							<div class="carousel-inner" role="listbox">
								<div class="carousel-item active">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-1.jpg") ?>" alt="First slide" />
									<div class="carousel-caption d-none d-md-block">
										<h3 class="text-white">First slide label</h3>
										<p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
									</div>
								</div>
								<div class="carousel-item">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-2.jpg") ?>" alt="Second slide" />
									<div class="carousel-caption d-none d-md-block">
										<h3 class="text-white">Second slide label</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
									</div>
								</div>
								<div class="carousel-item">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-3.jpg") ?>" alt="Third slide" />
									<div class="carousel-caption d-none d-md-block">
										<h3 class="text-white">Third slide label</h3>
										<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
									</div>
								</div>
							</div>
							<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</div>

					<div class="col-lg-6 mt-3 mt-lg-0">

				

						<!-- START carousel-->
						<div id="carouselExample" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carouselExample" data-slide-to="0" class="active"></li>
								<li data-target="#carouselExample" data-slide-to="1"></li>
								<li data-target="#carouselExample" data-slide-to="2"></li>
							</ol>
							<div class="carousel-inner" role="listbox">
								<div class="carousel-item active">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-4.jpg") ?>" alt="First slide" />
								</div>
								<div class="carousel-item">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-5.jpg") ?>" alt="Second slide" />
								</div>
								<div class="carousel-item">
									<img class="d-block img-fluid" src="<?php echo base_url("assets/images/small/img-6.jpg") ?>" alt="Third slide" />
								</div>
							</div>
						</div>
						<!-- END carousel-->
					</div>
				</div>
				<p></p>
				<div class="row">
					<div class="col-12">
						<div class="button-list ">
							<a class="btn btn-block btn-lg btn-blue waves-effect waves-light rounded" href="<?php echo site_url("jurnal") ?>"><i class="fa fa-search mr-1"></i> Cari Jurnal</a>

						</div>
					</div>
				</div>
				

			</div> <!-- end card-box -->
			
		</div> <!-- end col -->
	</div>



</div>