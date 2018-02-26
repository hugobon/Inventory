<div class="gallery text-left" id="links" style="min-height:100px;" >
	@if(count($imageArr) > 0)
		@foreach($imageArr->all() as $key => $row)
			@if(trim($row->path) != '')
				<?php
					$rowarr = array('delete' => 'delete_image','productId' => $productId,'deleteid' => $row->id);
					$base64data = trim(base64_encode(serialize($rowarr)), "=.");
				?>
				<a class="gallery-item" href="{{ url('storage/' . $row->path) }}" title="{{ $row->description != '' ? $row->description  : $productName }}" data-gallery>
					<div class="image">                              
						<img src="{{ url('storage/' . $row->path) }}" alt="{{ $row->description != '' ? $row->description  : $productName }}"/>                                        
						<ul class="gallery-item-controls">
							<li><span class="delete-image" data-base64="{{ $base64data }}"  ><i class="fa fa-times"></i></span></li>
						</ul>                                                                    
					</div>
					<div class="meta">
						<strong>{{ $row->description != '' ? $row->description  : $productName }}</strong>
					</div>                                
				</a>
			@endif
		@endforeach
	@else	
		No Image found
	@endif
</div>