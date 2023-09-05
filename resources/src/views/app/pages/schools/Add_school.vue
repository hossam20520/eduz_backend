
<template>
  <div class="main-content">
    <breadcumb :page="$t('AddSchool')" :folder="$t('Schools')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <validation-observer ref="Create_School" v-if="!isLoading">
      <b-form @submit.prevent="Submit_School" enctype="multipart/form-data">
        <b-row>
          <b-col md="8">
            <b-card>
              <b-row>


                
                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="lat"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('lat')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="lat"
                        :placeholder="$t('lat')"
                        v-model="school.lat"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="long"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('long')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="long"
                        :placeholder="$t('long')"
                        v-model="school.long"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>




                
                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="ar_name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('ar_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('ar_name')"
                        v-model="school.ar_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="en_name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('en_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="en_name"
                        :placeholder="$t('en_name')"
                        v-model="school.en_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>





                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="url"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('url')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="url"
                        :placeholder="$t('url')"
                        v-model="school.url"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="phone"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('phone')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="url"
                        :placeholder="$t('phone')"
                        v-model="school.phone"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="share"
                    :rules="{required:true , min:3 , max:600}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('share')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="share"
                        :placeholder="$t('share')"
                        v-model="school.share"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>




               <!-- Instatitian -->
                <b-col md="6" class="mb-2">
                  <validation-provider name="category" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Choose_instation')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_instation')"
                        v-model="school.institution_id"
                        :options="schools.map(schools => ({label: schools.ar_name, value: schools.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>




                
           
               <b-col md="6" class="mb-2">
                  <validation-provider name="Areas" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Choose_Area')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_Area')"
                        v-model="school.area_id"
                        :options="areas.map(areas => ({label: areas.ar_name, value: areas.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>
 
 
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('en_info')">
                    <vue-editor v-model="school.en_info" />
                  </b-form-group>
                </b-col>


                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('ar_info')">
                    <vue-editor v-model="school.ar_info" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('facilities_ar')">
                    <vue-editor v-model="school.facilities_ar" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('facilities_en')">
                    <vue-editor v-model="school.facilities_en" />
                  </b-form-group>
                </b-col>

          
     
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('activities_ar')">
                    <vue-editor v-model="school.activities_ar" />
                  </b-form-group>
                </b-col>
 

                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('activities_en')">
                    <vue-editor v-model="school.activities_en" />
                  </b-form-group>
                </b-col>









                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_en_info')">
                    <vue-editor v-model="school.paid_en_info" />
                  </b-form-group>
                </b-col>


                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_ar_info')">
                    <vue-editor v-model="school.paid_ar_info" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_facilities_ar')">
                    <vue-editor v-model="school.paid_facilities_ar" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_facilities_en')">
                    <vue-editor v-model="school.paid_facilities_en" />
                  </b-form-group>
                </b-col>


 
                <!-- free free  -->
                <b-col md="6" class="mb-2">
                  <validation-provider name="subscription" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('subscription')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="school.free"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_StatusSubscription')"
                        :options="
                            [
                              {label: 'free', value: 'free'},
                              {label: 'paid', value: 'paid'},
                    
                            ]"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="Product Cost"
                    :rules="{ required: true , regex: /^\d*\.?\d*$/}"
                    v-slot="validationContext"
                  >
                    <b-form-group :label="$t('from')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="ProductCost-feedback"
                        label="Cost"
                        :placeholder="$t('from')"
                        v-model="school.exp_from"
                      ></b-form-input>
                      <b-form-invalid-feedback
                        id="ProductCost-feedback"
                      >{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                
                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="exp_to Cost"
                    :rules="{ required: true , regex: /^\d*\.?\d*$/}"
                    v-slot="validationContext"
                  >
                    <b-form-group :label="$t('exp_to')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="ProductCost-feedback"
                        label="Cost"
                        :placeholder="$t('exp_to')"
                        v-model="school.exp_to"
                      ></b-form-input>
                      <b-form-invalid-feedback
                        id="ProductCost-feedback"
                      >{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="ar_address"
                    :rules="{required:true , min:3 , max:600}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('ar_address')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="share"
                        :placeholder="$t('ar_address')"
                        v-model="school.ar_address"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                <b-col md="6" class="mb-2">
                  <validation-provider
                    name="en_address"
                    :rules="{required:true , min:3 , max:600}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('en_address')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="share"
                        :placeholder="$t('en_address')"
                        v-model="school.en_address"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                <b-col md="6" class="mb-6" >
                  <validation-provider :name="dataArray"  >
                    <b-form-group slot-scope="{ valid, errors }" :label="$t( 'activites')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="school.actives"
                        :reduce="label => label.value"
                        :placeholder="$t('activites')"
                        multiple
                        :options="dataArray.map(dataArray => ({ label: dataArray.ar_name, value: dataArray.value }))"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

       


                
 

                <b-col md="6" class="mb-6" v-for="section in sections" :key="section.id">
                  <validation-provider :name="section.ar_name"  >
                    <b-form-group slot-scope="{ valid, errors }" :label="$t(section.ar_name)">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="selectedOptions[section.id]"
                        :reduce="label => label.value"
                        :placeholder="$t(section.ar_name)"
                        multiple
                        :options="section.drop.map(item => ({ label: item.en_name, value: item.id }))"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



 

                <!-- multiple -->
 
      

                   </b-row>
            </b-card>
          </b-col>
          <b-col md="4">
            <!-- upload-multiple-image -->
            <b-card>
              <div class="card-header">
                <h5>{{ $t('MultipleImage')}}</h5>
              </div>
              <div class="card-body">
                <b-row class="form-group">
                  <b-col md="12 mb-5">
                    <div
                      id="my-strictly-unique-vue-upload-multiple-image"
                      class="d-flex justify-content-center"
                    >
                      <vue-upload-multiple-image
                      @upload-success="uploadImageSuccess"
                      @before-remove="beforeRemove"
                      dragText="Drag & Drop Multiple images For school"
                      dropText="Drag & Drop image"
                      browseText="(or) Select"
                      accept=image/gif,image/jpeg,image/png,image/bmp,image/jpg
                      primaryText='success'
                      markIsPrimaryText='success'
                      popupText='have been successfully uploaded'
                      :data-images="images"
                      idUpload="myIdUpload"
                      :showEdit="false"
                      />
                    </div>
                  </b-col>
            
                </b-row>



                <b-row class="form-group">
                  <br> 
                  <b-col md="12 mb-5">
                    <div
                      id="my-strictly-unique-vue-upload-multiple-image"
                      class="d-flex justify-content-center"
                    >
               
                      <div>
                        
                        
                         <div style="display: inline;" v-for="(item, index) in files_activetiy" :key="index"> 
 
                         <span @click="deleteImage(index)" style="
    justify-content: center;
    position: absolute;
    padding: 5px;
    cursor: pointer;
    font-weight: bold;
    background-color: #9f9f9f6b;
    color: red;
    /* display: flex; */
"> X</span> <img width="50px" :src="'/images/uploads/'+item">

</div>
 


           
                   </div>
                    </div>
                  </b-col>
            
                </b-row>


                <b-row class="form-group">
                  <br> 
                  <b-col md="12 mb-5">
                    <div
                      id="my-strictly-unique-vue-upload-multiple-image"
                      class="d-flex justify-content-center"
                    >
 
                  <input type="file" ref="fileInput" multiple @change="handleFileChange">
                  <button type="button" @click="uploadFiles">Upload</button>
           
                  


                    </div>
                  </b-col>
            
                </b-row>



              </div>
            </b-card>
          </b-col>

          
          <b-col md="12" class="mt-3">
             <b-button variant="primary" type="submit" :disabled="SubmitProcessing">{{  $t('submit') }}</b-button>
              <div v-once class="typo__p" v-if="SubmitProcessing">
                <div class="spinner sm spinner-primary mt-3"></div>
              </div>
          </b-col>
        </b-row>
      </b-form>
    </validation-observer>
  </div>
</template>      




<script>
 
import VueUploadMultipleImage from "vue-upload-multiple-image";
import VueTagsInput from "@johmun/vue-tags-input";
import NProgress from "nprogress";
import { VueEditor } from "vue2-editor";

export default {
  metaInfo: {
    title: "Create school"
  },
  data() {
    return {
      tag: "",
      len: 8,
      dataArray:[ 
        {"ar_name": "منهج بريطاني" , "value": "British"} ,
        {"ar_name": "منهج منتسوري" , "value": "Montessori"},
        {"ar_name": "اخصائي تعديل سلوك" , "value": "Specialist"},
        {"ar_name": "وجبه للطفل" , "value": "Meal"},
        {"ar_name": "استضافه" , "value": "Hosting"},
        {"ar_name": "تحفيظ قران" , "value": "Quran"},
        {"ar_name": "حمام سباحه" , "value": "Swimming"},
        {"ar_name": "مواصلات" , "value": "Transportation"},

    ],
      images: [],
      imageArray: [],
      selectedOptions: {},
      selectedOptionsData: {},
      change: false,
      isLoading: true,
      SubmitProcessing:false,
      data: new FormData(),
      schools:[],
      areas:[],
      roles: {},
      facilites:[],
      school_types:[],
      sections:[],
      school: {
        exp_from:"",
        actives:"",
        exp_to:"",
        paid_en_info: "",
        paid_ar_info: "",
        paid_facilities_ar: "",
        paid_facilities_en: "",
        free:"",
        ar_address:"",
        en_address:"",


        banner:"",
        logo:"",
        area_id:"",
        ar_name:"",
        en_name:"",
        institution_id:"",
         url: "",
         phone: "",
         share: "",
         en_info: "",
         ar_info: "",
         facilities_ar: "",
         facilities_en: "",
         activities_ar: "",
         activities_en: "",
         image:"",
         lat:"",
         long:"",
         second_lang:"",
         first_lang:"",
         other_lang:"",
         years_accepted:"",
         weekend:"",
         expFrom:"",
         expTo:"",
         children_numbers:"",
         is_accept:"",
         activites_fiels:"",
      },
    
      files_activetiy: [],
      code_exist: ""
    };
  },

  components: {
 
    VueEditor,
    VueUploadMultipleImage,
    VueTagsInput
  },

  methods: {

    deleteImage(index) {
   
      this.files_activetiy.splice(index, 1);
      let strings =  this.files_activetiy.join(',');
      this.school.activites_fiels = strings;
      
    },

    handleFileChange(event) {
      this.selectedFiles = Array.from(event.target.files);
    },
    async uploadFiles() {
      const formData = new FormData();
      this.selectedFiles.forEach(file => {
        formData.append('files[]', file);
      });

      try {
        await axios.post('/files/upload', formData).then(response => { 
          console.log(response.data);
          this.activites_fiels = response.data.files;
          this.files_activetiy = response.data.files.split(",").map(item => item.trim());

          });// Assuming you're using Axios for HTTP requests
       
        
      } catch (error) {
        console.error('Error uploading files', error);
      }
    },

   
    sendData(){
      const postData = Object.entries(this.selectedOptions).map(([sectionId, selectedIds]) => {
        const section = this.sections.find(section => section.id === parseInt(sectionId));
        return {
          section_name: section.en_name,
          selected_ids: selectedIds,
        };
      });

      console.log(postData);
    },

    addFacilites() {
      this.facilites.push({ value: '' });

    },
 

 removeFromArrayF(index){
 
 if (index >= 0 && index < this.facilites.length) {
   this.facilites.splice(index, 1);
 }
     },




     async onFileSelected(e) {
      const { valid } = await this.$refs.Image.validate(e);

      if (valid) {
        this.school.logo = e.target.files[0];
      } else {
        this.school.logo = "";
      }
    },


    async onFileSelectedBanner(e) {
      const { valid } = await this.$refs.Banner.validate(e);

      if (valid) {
        this.school.banner = e.target.files[0];
      } else {
        this.school.banner = "";
      }
    },



    //------------- Submit Validation Create School
    Submit_School() {
     
    
     
      // this.sendData()
      this.$refs.Create_School.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
     
          this.Create_School();
        }
      });
    },

    //------ Toast
    makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },

    //------ Validation State
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------Show Notification If Variant is Duplicate
    showNotifDuplicate() {
      this.makeToast(
        "warning",
        this.$t("VariantDuplicate"),
        this.$t("Warning")
      );
    },

    //------ Event upload Image Success
    uploadImageSuccess(formData, index, fileList, imageArray) {
      this.images = fileList;
    },

    //------ Event before Remove Image
    beforeRemove(index, done, fileList) {
      var remove = confirm("remove image");
      if (remove == true) {
        this.images = fileList;
        done();
      } else {
      }
    },

    //-------------- School Get Elements
    GetElements() {
      axios
        .get("Schools/create")
        .then(response => {
          this.schools = response.data.schools;
        
          this.areas = response.data.areas;

          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },



    getSecions() {
      axios
        .get("drops/list/data?type=SCHOOLS")
        .then(response => {
          this.sections = response.data.SECIONS;
 

    
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

 

    //------------------------------ Create new School ------------------------------\
    Create_School() {

      
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      var self = this;
      self.SubmitProcessing = true;

 
      // append objet school
      Object.entries(self.school).forEach(([key, value]) => {
        self.data.append(key, value);
      });



      
      const allSelectedIds = Object.values(this.selectedOptions).flat();
      self.data.append('selected_ids', JSON.stringify(allSelectedIds));

     

                                                      
          //append array images
      if (self.images.length > 0) {
        for (var k = 0; k < self.images.length; k++) {
          Object.entries(self.images[k]).forEach(([key, value]) => {
            self.data.append("images[" + k + "][" + key + "]", value);
          });
        }
      }


      // Send Data with axios
      axios
        .post("Schools", self.data)
        .then(response => {
          console.log(this.selectedOptions)
          // Complete the animation of theprogress bar.
          NProgress.done();
          self.SubmitProcessing = false;
          this.$router.push({ name: "index_schools" });
          this.makeToast(
            "success",
            this.$t("Successfully_Created"),
            this.$t("Success")
          );
        })
        .catch(error => {

          
          // Complete the animation of theprogress bar.
          NProgress.done();
          if (error.errors.code.length > 0) {
            self.code_exist = error.errors.code[0];
          }
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
          self.SubmitProcessing = false;
        });
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    this.GetElements();
    this.getSecions();
  }
};
</script>
