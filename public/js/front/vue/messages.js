// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAhztOqMjG0YFWpRhlzQ2R-U8SCI6zcFwo",
  authDomain: "dhafar-c2e6b.firebaseapp.com",
  projectId: "dhafar-c2e6b",
  storageBucket: "dhafar-c2e6b.appspot.com",
  messagingSenderId: "1035993403227",
  appId: "1:1035993403227:web:738fbba2b264b1101d947e",
  measurementId: "G-QDH1W4MKK6",
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Access Firestore (optional if you need to use the Firestore database)
const db = firebase.firestore();

const i18n = new VueI18n({
  locale: "en", // Set the default locale
  messages: {
    en: {
      hello: "Hello",
      Items: "Items",
    },
    fr: {
      hello: "Bonjour",
      Items: "Items",
    },
  },
});

new Vue({
  el: "#appp",
  i18n,
  data: {
    showChat: true,
    load: true,
    user_id: 0,
    image: "",
    users:[],
    name: "",
    private: false,
    receiver_id: 0,
    color: "HSL(45,100%,50%)",
    messages: [],
    newMessage: "",
    baseImageUser:"",
    message: "Hello Vue!",
    local: "en",
    cart: [],

    baseUrl: "",
  },
  mounted() {
    // setInterval(this.colorChanger, 4000);
    this.local = this.$i18n.locale;
    var baseUrl = window.location.protocol + "//" + window.location.host + "/";
    // this.categoryImage = baseUrl + "images/category/";
    // this.productImage = baseUrl + "images/products/";
    this.baseUrl = baseUrl;
    this.baseImageUser = baseUrl + "images/avatar/";
 

    const urlParams = new URLSearchParams(window.location.search);


    if(urlParams.has("token")){
      const token = urlParams.get("token");
      this.getProfileData(token);




      this.FetchMessages();
    }
 

 







    // db.collection("users_messages")
    //   .doc(this.user_id)
    //   .where("to", "==", this.user_id)
    //   .get()
    //   .then((querySnapshot) => {

    //      querySnapshot.forEach((doc) => {
    //       const data = doc.data();
    //       const toValue = data.id;
    //       console.log(data);
    //       // uniqueToValues.add(toValue);
    //     });


    //     // const uniqueToValues = new Set();
    //     // querySnapshot.forEach((doc) => {
    //     //   const data = doc.data();
    //     //   const toValue = data.id;
    //     //   console.log(toValue);
    //     //   uniqueToValues.add(toValue);
    //     // });

    //     // // Convert the set to an array
    //     // const uniqueToValuesArray = Array.from(uniqueToValues);


    //     // this.FetchUsers(uniqueToValuesArray);

    //     // // Use the uniqueToValuesArray as needed
    //     // console.log(uniqueToValuesArray);
    //   })
    //   .catch((error) => {
    //     console.log("Error getting documents: ", error);
    //   });

      
  },
  methods: {


    
    getProfileData(token){
            

      axios.get('/api/device/auth/user' , {
          headers: {
              'Authorization': 'Bearer  ' + token
          }
      }).then(
              response => {
    
                  this.user = response.data.user;
                  const id =  response.data.user.id;
                  const image =  response.data.user.avatar;
                  const name = response.data.user.firstname + " "+response.data.user.lastname;
            
            
            
                  this.name = name;
                  this.image = this.baseUrl + "images/avatar/" + image;
                  this.user_id = id;
                  const urlParamss = new URLSearchParams(window.location.search);
                  if (urlParamss.has("user_id")) {
           
                    const userId = urlParamss.get("user_id");
                    this.private = true;
              
                    this.receiver_id = userId;
       
                  } 


               

     
              })
          .catch(error => {
              console.error(error);
          });


  },

    openChat(id){
      const url = '/chat?user_id='+id+'&replay=true&token=';
      // window.open(url);

      window.location.href = url;
    },
    FetchMessages() {
 
 

 


      db.collection("users_messages")
      .doc(2)
      .collection("messages")
      .orderBy("time")
      .onSnapshot((snapshot) => {
        snapshot.docChanges().forEach((change) => {
          if (change.type === "added") {
            const newMessage = change.doc.data();
            this.messages.push(newMessage);
            console.log(this.messages);
            // this.$nextTick(() => {
            //   this.$refs.chatMessages.scrollTop =
            //     this.$refs.chatMessages.scrollHeight;
            // });
          }
        });
      });



 

    },

    close() {
      this.showChat = false;
    },
  
 
  },
});
