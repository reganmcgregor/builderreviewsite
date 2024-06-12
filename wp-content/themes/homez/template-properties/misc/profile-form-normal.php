<?php
$user = wp_get_current_user();
$data = get_userdata( $user->ID );
$avatar = get_the_author_meta( '_user_avatar', $user->ID );
$avatar_url = wp_get_attachment_image_src($avatar, 'full');
$address = get_the_author_meta( '_address', $user->ID );
$phone = get_the_author_meta( '_phone', $user->ID );
$whatsapp = get_the_author_meta( '_whatsapp', $user->ID );

wp_enqueue_script( 'wp-realestate-ajax-file-upload' );
?>
<div class="profile-form-normal-wrapper">
	<h1 class="title-profile"><?php esc_html_e( 'Edit Profile', 'homez' ) ; ?></h1>
	<div class="box-white-dashboard">
		<div class="clearfix">
			<?php if ( ! empty( $_SESSION['messages'] ) ) : ?>

				<?php foreach ( $_SESSION['messages'] as $message ) { ?>
					<?php
					$status = !empty( $message[0] ) ? $message[0] : 'success';
					if ( !empty( $message[1] ) ) {
					?>
					<div class="alert alert-<?php echo esc_attr( $status ) ?> margin-bottom-15">
						<?php echo trim( $message[1] ); ?>
					</div>
				<?php
					}
				}
				unset( $_SESSION['messages'] );
				?>

			<?php endif; ?>

			<form method="post" action="" class="change-profile-form form-theme">
				<div class="cmb2-wrap">
					<div class="left-inner form-group">
				        <h3 class="sub"><?php echo esc_html__( 'Change Avatar', 'homez' ); ?></h3>
				        <div class="wp-realestate-uploaded-files">
				            <?php if (  $avatar ) { ?>
				                <div class="wp-realestate-uploaded-file">
				                    <?php
				                    $image_src = wp_get_attachment_image_src( absint( $avatar ) );
				                    $image_src = $image_src ? $image_src[0] : '';

				                    $extension = ! empty( $extension ) ? $extension : substr( strrchr( $image_src, '.' ), 1 );

				                    if ( 3 !== strlen( $extension ) || in_array( $extension, array( 'jpg', 'gif', 'png', 'jpeg', 'jpe' ) ) ) : ?>
				                        <span class="wp-realestate-uploaded-file-preview"><img src="<?php echo esc_url( $image_src ); ?>" /> <a class="wp-realestate-remove-uploaded-file" href="#"><?php esc_html_e( 'remove', 'homez' ); ?></i></a></span>
				                    <?php else : ?>
				                        <span class="wp-realestate-uploaded-file-name"><code><?php echo esc_html( basename( $image_src ) ); ?></code> <a class="wp-realestate-remove-uploaded-file" href="#"><?php esc_html_e( 'remove', 'homez' ); ?></a></span>
				                    <?php endif; ?>

				                    <input type="hidden" class="input-text" name="user_avatar" value="<?php echo esc_attr( $avatar ); ?>" />
				                </div>
				            <?php } ?>
				        </div>
				        <input id="upload-image-avarta" class="widefat wp-realestate-file-upload input-text hidden" name="user_avatar" type="file" value="<?php echo esc_attr($avatar); ?>" data-file_types="jpg|jpeg|jpe|gif|png"/>

				        <label class="label-can-drag">
							<div class="form-group group-upload">
						        <div class="upload-file-btn">
					            	<span><?php esc_html_e('Upload Image', 'homez'); ?></span>
						        </div>
						    </div>
						</label>
				    </div>
					<div class="row">
				        <div class="col-md-6 col-12">
				        	<div class="form-group">
					        	<label for="change-profile-form-first-name" class="for-control"><?php  esc_attr_e( 'First name', 'homez' ); ?></label>
				                <input id="change-profile-form-first-name" type="text" name="first_name" class="form-control" value="<?php echo ! empty( $data->first_name ) ? esc_attr( $data->first_name ) : ''; ?>">
			                </div>
				        </div><!-- /.form-group -->
				        <div class="col-md-6 col-12">
				            <div class="form-group">
				            	<label for="change-profile-form-last-name" class="for-control"><?php  esc_attr_e( 'Last Name', 'homez' ); ?></label>
			                	<input id="change-profile-form-last-name" type="text" name="last_name" class="form-control" value="<?php echo ! empty( $data->last_name ) ? esc_attr( $data->last_name ) : ''; ?>">
			                </div>
				            
				        </div><!-- /.form-group -->
				        <div class="col-md-6 col-12">
				        	<div class="form-group">
				        		<label for="change-profile-form-email" class="for-control"><?php  esc_attr_e( 'Email', 'homez' ); ?></label>
			                	<input id="change-profile-form-email" type="email" name="email" class="form-control" value="<?php echo ! empty( $data->user_email ) ? esc_attr( $data->user_email ) : ''; ?>"  required="required">
			                </div>
				        </div><!-- /.form-group -->

				        <div class="col-md-6 col-12">
				        	<div class="form-group">
				        		<label for="change-profile-form-phone" class="for-control"><?php  esc_attr_e( 'Phone', 'homez' ); ?></label>
			                	<input id="change-profile-form-phone" type="text" name="phone" class="form-control" value="<?php echo ! empty( $phone ) ? esc_attr( $phone ) : ''; ?>">
			                </div>
				        </div><!-- /.form-group -->
				        <div class="col-md-6 col-12">
				        	<div class="form-group">
				        		<label for="change-profile-form-whatsapp" class="for-control"><?php  esc_attr_e( 'Whatsapp', 'homez' ); ?></label>
			                	<input id="change-profile-form-whatsapp" type="text" name="whatsapp" class="form-control" value="<?php echo ! empty( $whatsapp ) ? esc_attr( $whatsapp ) : ''; ?>">
			                </div>
				        </div><!-- /.form-group -->

				        <div class="col-md-6 col-12">
				        	<div class="form-group">
				        		<label for="change-profile-form-address" class="for-control"><?php  esc_attr_e( 'Address', 'homez' ); ?></label>
			                	<input id="change-profile-form-address" type="text" name="address" class="form-control" value="<?php echo ! empty( $address ) ? esc_attr( $address ) : ''; ?>">
			                </div>
				        </div><!-- /.form-group -->

				        <div class="col-md-6 col-12">
				        	<div class="form-group">
				        		<label for="change-profile-form-url" class="for-control"><?php  esc_attr_e( 'Website', 'homez' ); ?></label>
			                	<input id="change-profile-form-url" type="text" name="url" class="form-control" value="<?php echo ! empty( $data->url ) ? esc_attr( $data->url ) : ''; ?>">
			                </div>
				        </div><!-- /.form-group -->
				    </div>

				    <div class="form-group">
				    	<label for="change-profile-form-about" class="for-control"><?php  esc_attr_e( 'Biographical Info', 'homez' ); ?></label>
			            <textarea id="change-profile-form-about" class="form-control" name="description" cols="70" rows="5"><?php echo ! empty( $data->description ) ? esc_attr( $data->description ) : ''; ?></textarea>
				    </div><!-- /.form-group -->

				    <?php wp_nonce_field('edit-profile-normal-nonce', 'edit-profile-normal'); ?>

				    <button type="submit" name="change_profile_form" class="button btn btn-theme btn-inverse"><?php echo esc_html__( 'Save Profile', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
			    </div>
			</form>
		</div>	
	</div>
</div>