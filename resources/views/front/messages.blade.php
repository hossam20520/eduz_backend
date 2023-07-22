@extends('front.base')

@section('content')
 
  
<div id="appp"> 

 
  <section  class=" "  style="padding:0"  v-show="showChat"  >
    <div class=" ">
        
      <div class="row d-flex justify-content-center">
        <div class="col-md-8">
  
          <div class="card">
       
            <div class="card-body scroll"  data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px" ref="chatMessages" >

     


             <div v-for="item in messages"  >
             
              
              
       






               <div    >
              <div class="d-flex justify-content-between">
                
                {{-- <p class="small mb-1 text-muted">@{{ message.time }}</p> --}}
              </div>
             
              <div  class="d-flex flex-row justify-content-start">
                <img  v-on:click="openChat(item.id)"   :src="baseImageUser + item.avatar"
                  alt="avatar 1" style="width: 45px; height: 100%;">
                  {{-- <span style="
                  width: 10px;
                  background-color: red;
                  height: 10px;
                  border-radius: 50%;
              ">  </span> --}}
               

           
                       {{-- <p  class="small p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;" v-if="load">
                        @{{ message.text }}
                       </p> --}}

                   <p class="small p-2 ms-3 mb-3 rounded-1" style="background-color: #f5f6f7;" > @{{ item.firstname }}   @{{ item.lastname }} </span>
                   </p>

                </div>
              </div>
               </div>

       
               
             </div>

  
            </div>
           
          </div>
  
        </div>
      </div>
  
    </div>
  </section>
</div>
 


 

  @endsection
  

  @push('scripts')
  {{-- <script src="{{ asset('js/front/vue/vue.global.min.js') }}"></script> --}}
<script src="{{ asset('js/front/vue/messages.js') }}"></script>
@endpush
