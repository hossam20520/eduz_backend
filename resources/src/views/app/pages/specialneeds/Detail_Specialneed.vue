
<template>
  <div class="main-content">
    <breadcumb :page="$t('SpecialneedDetails')" :folder="$t('Specialneeds')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <b-card no-body v-if="!isLoading">
      <b-card-header>
 
      </b-card-header>
      <b-card-body>
        <b-row id="print_specialneed">
  

          <b-col md="8">
            <table class="table table-hover table-bordered table-md">
              <tbody>
                <tr>
                  <td> {{  $t('ar_name') }}</td>
                  <th> {{  specialneed.ar_name  }}</th>
                </tr>
                <tr>
                  <td> {{  $t('en_name')  }}</td>
                  <th> {{  specialneed.en_name   }}</th>
                </tr>

                <tr>
                  <td> {{  $t('en_info')  }}</td>
                  <th v-html="specialneed.en_info">  </th>
                </tr>


                <tr>
                  <td> {{  $t('ar_info')  }}</td>
                  <th v-html="specialneed.ar_info">  </th>
                </tr>

                <tr>
                  <td> {{  $t('facilities_ar')  }}</td>
                  <th  v-html="specialneed.facilities_ar"> </th>
                </tr>


                <tr>
                  <td> {{  $t('facilities_en')  }}</td>
                  <th  v-html="specialneed.facilities_en"> </th>
                </tr>




                <tr>
                  <td> {{  $t('url')  }}</td>
                  <th> {{  specialneed.url   }}</th>
                </tr>
 

                
                <tr>
                  <td> {{  $t('phone')  }}</td>
                  <th> {{  specialneed.phone   }}</th>
                </tr>


                
                <tr>
                  <td> {{  $t('share')  }}</td>
                  <th> {{  specialneed.share   }}</th>
                </tr>

     
              </tbody>
            </table>
          </b-col>
          <b-col md="4" class="mb-30">
            <div class="carousel_wrap">
              <b-carousel
                id="carousel-1"
                :interval="2000"
                controls
                background="#ababab"
                img-width="1024"
                img-height="480"
                @sliding-start="onSlideStart"
                @sliding-end="onSlideEnd"
              >
                <b-carousel-slide
                  v-for="(image, index) in specialneed.images"
                  :key="index"
                  :img-src="'/images/educations/'+image"
                ></b-carousel-slide>
              </b-carousel>
            </div>
          </b-col>

          <!-- Warehouse Quantity -->
          <b-col md="5" class="mt-4">
            <table class="table table-hover table-sm">
          
     
            </table>
          </b-col>
          <!-- Warehouse Variants Quantity -->
  
        </b-row>
      </b-card-body>
    </b-card>
  </div>
</template>


<script>
import VueBarcode from "vue-barcode";
import { mapActions, mapGetters } from "vuex";

export default {
  metaInfo: {
    title: "Detail Specialneed"
  },
  components: {
    barcode: VueBarcode
  },

  data() {
    return {
      len: 8,
      images: [],
      imageArray: [],
      isLoading: true,
      specialneed: {},
      roles: {},
      variants: []
    };
  },
  computed: {
    ...mapGetters(["currentUser"])
  },

  methods: {
    //------- printspecialneed
    print_specialneed() {
      var divContents = document.getElementById("print_specialneed").innerHTML;
      var a = window.open("", "", "height=500, width=500");
      a.document.write(
        '<link rel="stylesheet" href="/assets_setup/css/bootstrap.css"><html>'
      );
      a.document.write("<body >");
      a.document.write(divContents);
      a.document.write("</body></html>");
      a.document.close();
      a.print();
    },

    //------------------------------Formetted Numbers -------------------------\
    formatNumber(number, dec) {
      const value = (typeof number === "string"
        ? number
        : number.toString()
      ).split(".");
      if (dec <= 0) return value[0];
      let formated = value[1] || "";
      if (formated.length > dec)
        return `${value[0]}.${formated.substr(0, dec)}`;
      while (formated.length < dec) formated += "0";
      return `${value[0]}.${formated}`;
    },

    //----------------------------------- Get Details Specialneed ------------------------------\
    showDetails() {
      let id = this.$route.params.id;
      axios
        .get(`Specialneeds/Detail/${id}`)
        .then(response => {
          this.specialneed = response.data;
          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    this.showDetails();
  }
};
</script>