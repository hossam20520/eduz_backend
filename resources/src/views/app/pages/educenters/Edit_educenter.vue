<template>
  <div class="main-content">
    <breadcumb :page="'Update Educenter'" :folder="$t('Educenters')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <validation-observer ref="Edit_Educenter" v-if="!isLoading">
      <b-form @submit.prevent="Submit_Educenter" enctype="multipart/form-data">
        <b-row>
          <b-col md="8">
            <b-card>
              <b-card-body>
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
                        v-model="educenter.lat"
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
                        v-model="educenter.long"
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
                        v-model="educenter.ar_name"
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
                        v-model="educenter.en_name"
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
                        v-model="educenter.url"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                <b-col md="6" class="mb-2">
                  <validation-provider name="Govs" :rules="{ required: true }">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Choose_Gov')">
                      <v-select :class="{ 'is-invalid': !!errors.length }"
                        :state="errors[0] ? false : (valid ? true : null)" :reduce="label => label.value"
                        :placeholder="$t('choosGov')" v-model="educenter.gov_id"
                        v-on:input="handleChange"
                        :options="govs.map(govs => ({ label: govs.ar_name, value: govs.id }))" />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                <b-col md="6" class="mb-2">
                  <validation-provider name="Areas" :rules="{ required: true }">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Choose_Area')">
                      <v-select :class="{ 'is-invalid': !!errors.length }"
                        :state="errors[0] ? false : (valid ? true : null)" :reduce="label => label.value"
                        :placeholder="$t('Choose_Area')" v-model="educenter.area_id"
                        :options="areas.map(areas => ({ label: areas.ar_name, value: areas.id }))" />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
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
                        v-model="educenter.phone"
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
                        v-model="educenter.institution_id"
                        :options="educenters.map(educenters => ({label: educenters.ar_name, value: educenters.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


      
  


                <b-col md="12" class="mb-12">
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
                        v-model="educenter.share"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('en_info')">
                    <vue-editor v-model="educenter.en_info" />
                  </b-form-group>
                </b-col>


                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('ar_info')">
                    <vue-editor v-model="educenter.ar_info" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('facilities_ar')">
                    <vue-editor v-model="educenter.facilities_ar" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('facilities_en')">
                    <vue-editor v-model="educenter.facilities_en" />
                  </b-form-group>
                </b-col>

          
     
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('activities_ar')">
                    <vue-editor v-model="educenter.activities_ar" />
                  </b-form-group>
                </b-col>
 

                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('activities_en')">
                    <vue-editor v-model="educenter.activities_en" />
                  </b-form-group>
                </b-col>






                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_en_info')">
                    <vue-editor v-model="educenter.paid_en_info" />
                  </b-form-group>
                </b-col>


                
                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_ar_info')">
                    <vue-editor v-model="educenter.paid_ar_info" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_facilities_ar')">
                    <vue-editor v-model="educenter.paid_facilities_ar" />
                  </b-form-group>
                </b-col>



                <b-col md="12" class="mb-2">
                  <b-form-group :label="$t('paid_facilities_en')">
                    <vue-editor v-model="educenter.paid_facilities_en" />
                  </b-form-group>
                </b-col>



                <!-- free free  -->
                <b-col md="6" class="mb-2">
                  <validation-provider name="subscription" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('subscription')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="educenter.free"
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
                        v-model="educenter.exp_to"
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
                        v-model="educenter.ar_address"
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
                        v-model="educenter.en_address"
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
                        v-model="educenter.actives"
                        :reduce="label => label.value"
                        :placeholder="$t('activites')"
                        multiple
                        :options="dataArray.map(dataArray => ({ label: dataArray.ar_name, value: dataArray.value }))"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>





   
                <!-- <b-col md="12"  class="mb-2">
              <validation-provider name="Image" ref="Image" rules="mimes:image/*">
                <b-form-group slot-scope="{validate, valid, errors }" :label="$t('Logo')">
                  <input
                    :state="errors[0] ? false : (valid ? true : null)"
                    :class="{'is-invalid': !!errors.length}"
                    @change="onFileSelected"
                    label="Choose Image"
                    type="file"
                  >
                  <b-form-invalid-feedback id="Image-feedback">{{ errors[0] }}</b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col> -->


            <!-- <b-col md="12"  class="mb-2">
              <validation-provider name="Banner" ref="Banner" rules="mimes:image/*">
                <b-form-group slot-scope="{validate, valid, errors }" :label="$t('Banner')">
                  <input
                    :state="errors[0] ? false : (valid ? true : null)"
                    :class="{'is-invalid': !!errors.length}"
                    @change="onFileSelectedBanner"
                    label="Choose Image"
                    type="file"
                  >
                  <b-form-invalid-feedback id="Image-feedback">{{ errors[0] }}</b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col> -->


            
 
         
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





 
                </b-row>
              </b-card-body>
            </b-card>
          </b-col>
          <b-col md="4">
            <b-card>
              <div class="card-header">
                <h5>{{  $t('MultipleImage') }}</h5>
              </div>
              <div class="card-body">
                <b-row class="form-group">
                  <b-col md="12 mb-5">
                    <div
                      id="my-strictly-unique-vue-upload-multiple-image"
                      class="d-flex justify-content-center">
                      <vue-upload-multiple-image
                      @upload-success="uploadImageSuccess"
                      @before-remove="beforeRemove"
                      dragText="Drag & Drop Multiple images For educenter"
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
                  <b-col md="12 mb-5">
                    <div id="my-strictly-unique-vue-upload-multiple-image" class="d-flex justify-content-center">
                      <vue-upload-multiple-image @upload-success="uploadImageSuccess_tow" @before-remove="beforeRemove_tow"
                        dragText="Drag & Drop Multiple images For educenter" dropText="Drag & Drop image"
                        browseText="(or) Select" accept=image/gif,image/jpeg,image/png,image/bmp,image/jpg
                        primaryText='success' markIsPrimaryText='success' popupText='have been successfully uploaded'
                        :data-images="images_tow" idUpload="myIdUploadTow" :showEdit="false" />
                    </div>
                  </b-col>

                </b-row>

 
 

              </div>
            </b-card>
          </b-col>
          <b-col md="12" class="mt-3">
             <b-button variant="primary" type="submit" :disabled="SubmitProcessing">{{ $t('submit') }}</b-button>
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
    title: "Edit Educenter"
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
      images_tow:[],
      imageArray: [],
      areas:[],
      govs:[],
      change: false,
      isLoading: true,
      SubmitProcessing:false,
      data: new FormData(),
      sections:[],
      selectedOptions: {},
      roles: {},
      variants: [],
      educenters:[],
      educenter: {
        exp_from:"",
        exp_to:"",
        actives:"",
        paid_en_info: "",
        paid_ar_info: "",
        paid_facilities_ar: "",
  paid_facilities_en: "",
               free:"",
         ar_address:"",
         en_address:"",
        images_tow: "",
               logo:"",
             banner:"",
            area_id:"",
            gov_id:"",
     institution_id:"",
           ar_name:"",
            en_name:"",
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



    handleChange(selectedValue){
   
   this.getItems(selectedValue);

 },

 getItems(id){


// Start the progress bar.
// NProgress.start();
// NProgress.set(0.1);
axios.get(
 "drops/getarea?gov_id=" +  id 
   
)
.then(response => {
 this.areas = response.data.areas;



 // Complete the animation of theprogress bar.
 // NProgress.done();
 // this.isLoading = false;
})
.catch(response => {
 // Complete the animation of theprogress bar.
 NProgress.done();
 setTimeout(() => {
   this.isLoading = false;
 }, 500);
});

},



    deleteImage(index) {
   
   this.files_activetiy.splice(index, 1);
   let strings =  this.files_activetiy.join(',');
   this.educenter.activites_fiels = strings;
   
 },



         //------ Event upload Image Success
    uploadImageSuccess_tow(formData, index, fileList, imageArray) {
      this.images_tow = fileList;
    },




    //------ Event before Remove Image
    beforeRemove_tow(index, done, fileList) {
      var remove = confirm("remove image");
      if (remove == true) {
        this.images_tow = fileList;
        done();
      } else {
      }
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
 

    async onFileSelectedBanner(e) {
      const { valid } = await this.$refs.Banner.validate(e);

      if (valid) {
        this.educenter.banner = e.target.files[0];
      } else {
        this.educenter.banner = "";
      }
    },


    async onFileSelected(e) {
      const { valid } = await this.$refs.Image.validate(e);

      if (valid) {
        this.educenter.logo = e.target.files[0];
      } else {
        this.educenter.logo = "";
      }
    },

    getSecions() {
      axios
      .get("drops/list/data?type=EDUCENTERS")
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
    //------------- Submit Validation Update Educenter
    Submit_Educenter() {
      this.$refs.Edit_Educenter.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          this.Update_Educenter();
        }
      });
    },

    //------ Validation state fields
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------ Toast
    makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },

    //------Show Notification If Variant is Duplicate
    showNotifDuplicate() {
      this.makeToast(
        "warning",
        this.$t("VariantDuplicate"),
        this.$t("Warning")
      );
    },

   

    //------ event upload Image Success
    uploadImageSuccess(formData, index, fileList, imageArray) {
      this.images = fileList;
    },

    //------ event before Remove image
    beforeRemove(index, done, fileList) {
      var remove = confirm("remove image");
      if (remove == true) {
        this.images.splice(index, 1);
        done();
      } else {
      }
    },

    //---------------------------------------Get Educenter Elements ------------------------------\
    GetElements() {
      let id = this.$route.params.id;
      axios
        .get(`Educenters/${id}/edit`)
        .then(response => {
         
          this.educenter = response.data.educenter;
          this.areas = response.data.areas;
          this.govs = response.data.govs;
          console.log( response.data.govs);
          // this.files_activetiy = response.data.educenter.activites_fiels.split(",").map(item => item.trim());
          this.educenter.actives =    response.data.educenter.actives 
          // this.files_activetiy = response.data.educenter.activites_fiels.split(",").map(item => item.trim());
          // console.log( response.data.drop.SECTIONS)
 
            let da = response.data.drops.original;
            da.forEach(section => {
        this.$set(this.selectedOptions, section.id, section.drop.map(item => item.id));
      });


          // console.log("ddddddddddddddddddddddddddddddddddddd")
          // // this.selectedOptions = response.data.drops.original;

          this.educenters =  response.data.educenters;
          this.images = response.data.educenter.images;
          this.images_tow = response.data.educenter.images_tow;
          // this.image_tow = response.data.educenter.image_tow;
          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    },

 
 

    //------------------------------ Update Educenter ------------------------------\
    Update_Educenter() {
      NProgress.start();
      NProgress.set(0.1);
      var self = this;
      self.SubmitProcessing = true;
 

       // append objet educenter
      Object.entries(self.educenter).forEach(([key, value]) => {
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


      
            //append array images
            if (self.images_tow.length > 0) {
        for (var k = 0; k < self.images_tow.length; k++) {
          Object.entries(self.images_tow[k]).forEach(([key, value]) => {
            self.data.append("images_tow[" + k + "][" + key + "]", value);
          });
        }
      }

      self.data.append("_method", "put");

      //send Data with axios
      axios.post("Educenters/" + this.educenter.id, self.data).then(response => {
          NProgress.done();
          self.SubmitProcessing = false;
          this.$router.push({ name: "index_educenters" });
          this.makeToast(
            "success",
            this.$t("Successfully_Updated"),
            this.$t("Success")
          );
        })
        .catch(error => {
          if (error.errors.code.length > 0) {
              self.code_exist = error.errors.code[0];
          }
          NProgress.done();
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
          self.SubmitProcessing = false;
        });
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    this.GetElements();
    this.getSecions();
    this.imageArray = [];
    this.images = [];
  }
};
</script>
