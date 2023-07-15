 
 @extends('front.base')


 @section('content')
     


 <div id="appp"> 

 
    <section  class=" "  v-show="showChat"  >
      <div class="container py-5">
          
        <div class="row d-flex justify-content-center">
          <div class="col-md-8">
    
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center p-3"
                style="border-top: 4px solid #ffa900;">
                <h5 class="mb-0">Global Chat</h5>
                <div class="d-flex flex-row align-items-center">
                
                  <i class="bi bi-x-square"  style="color: red;"></i>
                </div>
              </div>
              <div class="card-body scroll"  data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px" ref="chatMessages" >
  
       
  
  
               <div v-for="message in messages" :key="message.id">
               
                
                
                <div v-if="message.id ===  user_id">
  
  
                  <div class="d-flex justify-content-between">
                      <p class="small mb-1 text-muted">Today</p>
                      <p class="small mb-1">You</p>
                  </div>
                  <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                      <div>
                      <p class="small p-2 me-3 mb-3 text-white rounded-3 bg-warning">@{{ message.text }}</p>
                      </div>
                      <img v-if='user_id == 0' :src="message.image"
                      alt="avatar 1" style="width: 45px; height: 100%;">
  
                      <img  v-else :src="message.image"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                  </div>
  
              </div>
  
  
  
  
  
  
  
                 <div   v-else>
                 <div class="d-flex justify-content-between">
                  <p class="small mb-1">@{{ message.name }}</p>
                  {{-- <p class="small mb-1 text-muted">@{{ message.time }}</p> --}}
                </div>
  
                <div class="d-flex flex-row justify-content-start">
                  <img :src="message.image"
                    alt="avatar 1" style="width: 45px; height: 100%;">
                  <div>
                         {{-- <p  class="small p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;" v-if="load">
                          @{{ message.text }}
                         </p> --}}
  
                     <p class="small p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;" >@{{ message.text }}
                     </p>
  
                  </div>
                </div>
                 </div>
  
  
  
  
                 
  
         
                 
               </div>
  
    
              </div>
              <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                <div class="input-group mb-0">
                  <input style="height:41px;" v-model="newMessage" type="text" class="form-control" placeholder="Type message"
                    aria-label="Recipient's username" aria-describedby="button-addon2" />
                  <button class="btn btn-warning" @click="sendMessage" type="button" id="button-addon2" style="padding-top: .55rem;">
                    send
                  </button>
                </div>
              </div>
            </div>
    
          </div>
        </div>
    
      </div>
    </section>
  </div>
   
  
  
 @endsection