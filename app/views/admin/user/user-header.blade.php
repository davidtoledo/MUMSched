	<div style="margin: 1%;">
		<div id="profile">
			<div id="pad-wrapper">
	

	         <div class="row">
	            <div class="col-xs-12">
	               <div>
	                  <div class="clearfix user-card">
	                     <div class="row row-same-height">
	                        <div class="col-md-9 col-xs-height with-greybar">
	                           <div class="row">
	                              <div class="img-container pull-left">
	                              	
				                     <!-- tab -->
				                     @if ( Request::is('*/perfil/*/*/perfil' ) )  
	                              	 	<a href="#2" onclick="uploadPerfil();">
	                              	 @endif
	                              	 	<?php
	                              	 		if ($user->img_profile == null) {
	                              	 			$perfil_foto = "_plataforma/media/img/dtsc/";
	                              	 			$perfil_foto = ($user->type == \SystemUser::TYPE_FACULTY ? $perfil_foto . 'mentor.png' : $perfil_foto . 'mentorado.png');
											} else {
												$perfil_foto = $user->img_profile;
											}
	                              	 	?>
	                                 	<img id="preview" src="{{ URL::to ($perfil_foto) }}" width="120px;" class="img-perfil-rounded" />
				                     <!-- Aba Perfil -->
				                     @if ( Request::is('*/perfil/*/*/perfil' ) )  
	                              	 	</a>
	                              	 @endif
	                                 <div class="grade" align="center">
	                                	<span class="form-label">
	                                		@if ( $user->type == \SystemUser::TYPE_FACULTY )
	                                			<span class="form-label">Faculty</span>
	                                		@else 
	                                			<span class="form-label">Student</span>
	                                		@endif  
	                                	</span>		                                
	                                 </div>
	                              </div>
	                              <div class="col-md-5">
	                                 <div class="personal-information">
	                                    <h1>
	                                       <a href="#2">{{ $user->first_name }} {{ $user->last_name }}</a>
	                                    </h1>
	                                    <h3>
	                                       <span class="role">
		                                		@if ( $user->type == \SystemUser::TYPE_FACULTY )
		                                			Faculty
		                                		@else
		                                			Student
		                                		@endif  
	                                       </span>
	                                       <span>
	                                       &nbsp;&nbsp;
	                                       </span>
	                                       <small>
	                                       <br><b>
	                                       		@if ( $user->type == \SystemUser::TYPE_STUDENT )
	                                       			GPA 3.8
	                                       		@else
	                                       			&nbsp;
	                                       		@endif
	                                       	</b>
	                                       </small>
	                                    </h3>
	                                    <p></p>
	                                    <div>
	                                    	@if ( $user->type == \SystemUser::TYPE_STUDENT )
	                                       		<span class="form-answer"><b>Master's Degree</b></span>
	                                       	@else
	                                       		<span class="form-answer"><b>Doctor's Degree</b></span>
	                                       	@endif
	                                    </div>	                                    
	                                    <div>
	                                       <span class="form-answer"><b>Computer Science</b></span>
	                                    </div>
	                                    <p></p>
	                                    <div>
	                                    	@if ( $user->type == \SystemUser::TYPE_STUDENT )
		                                        <span class="form-label">Track:</span>
		                                        <span class="form-answer">{{ $user->student_track }}</span>
	                                      	@endif
	                                    </div>
	                                    <div>
	                                       <span class="form-label">State:</span>
	                                       <span class="form-answer">Iowa</span>
	                                    </div>
	                                    <p></p>
	                                 </div>
	                              </div>
	                              <div class="col-md-5">
	                                 <div class="personal-preferences">
	                                 		@if (Auth::user()->type == \SystemUser::TYPE_STUDENT)
		                                    <div class="mentoring-preference">
		                                       <h3 class="form-label">Availability</h3>
		                                       <div class="form-answer">
		                                          <div style="overflow: hidden; max-height: 54px;">
		                                             <div style="margin: 0px; padding: 0px; border: 0px;">
		                                                Full Time
		                                             </div>
		                                          </div>
		                                       </div>
		                                    </div>
		                                    @endif
		                                    
		                                    <div class="contatos-plataforma">
		                                       <h3 class="form-label">University Contacts</h3>
		                                       <div class="form-answer">
		                                          <div style="overflow: hidden; max-height: 54px;">
		                                             <div style="margin: 0px; padding: 0px; border: 0px;">
		                                             	&bull; Joe Bruen
		                                             </div>
		                                          </div>
		                                       </div>
		                                    </div>		                                		                                    
                           	
		                                    @if (Auth::user()->type == \SystemUser::TYPE_STUDENT)
		                                    <div class="general-impression">
		                                       <h3 class="form-label">Student Entry</h3>
		                                       <div class="form-answer">
		                                          <div style="overflow: hidden; max-height: 54px;">
		                                             <div style="margin: 0px; padding: 0px; border: 0px;">
		                                                &bull; {{ sizeof($user->entry) > 0 ? $user->entry->name : "Not assigned yet" }}
		                                             </div>
		                                          </div>
		                                       </div>
		                                    </div>
		                                    @else
		                                    <div class="general-impression">
		                                       <h3 class="form-label">Courses</h3>
		                                       <div class="form-answer">
		                                          <div style="overflow: hidden;">
		                                             <div style="margin: 0px; padding: 0px; border: 0px;">
		                                             	@foreach ($user->courses as $crse)
	                              							<li class="form-answer">{{ $crse->course->name }}</li>
	                              						@endforeach
		                                             </div>
		                                          </div>
		                                       </div>
		                                    </div>		                                    
		                                    @endif

	                                 </div>
	                              </div>
	                           </div>
	                        </div>
	                        
	                        <div class="col-md-3 col-xs-height skills">
	                           <div id="skill_rankings">
	                              <h3 class="form-label">Specialization</h3>
	                              <ul>
	                              	@if (Auth::user()->type == \SystemUser::TYPE_FACULTY)
	                              		@foreach ($user->specializations as $spec)
	                              			<li class="form-answer">{{ $spec->specialization->specialization }}</li>
	                              		@endforeach
	                              	@else
	                              		<li class="form-answer">Bachelor Degree</li>
	                              		<li class="form-answer">Master's Degree</li>
	                              	@endif
	                              </ul>
	                           </div>
	                        </div>
	                        
	                     </div>
	                  </div>
	               </div>
	            </div>
	         </div>