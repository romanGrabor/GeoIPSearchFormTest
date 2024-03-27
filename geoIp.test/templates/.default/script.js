const SendThanks = {
    data() {
        return {
            IP             : '',
            coordinates    : '',
            city           : '',
            region         : '',
            country        : '',
            inputIP        : '',
            axiosFilePath  : '',
            highloadblockId: '',
            seen           : false,
            postData       : {
                'inputIP'        : '',
                'highloadblockId': ''
            }
        };
    },
    methods: {
        searchInfo() {
            this.axiosFilePath = document.querySelector("#templateFolder").value + '/axios.php';
            this.highloadblockId = document.querySelector("#highloadblockId").value;
            this.postData['inputIP'] = this.inputIP;
            this.postData['highloadblockId'] = this.highloadblockId;

            axios.post(this.axiosFilePath, this.postData).then(response => {
                if (response.data.ip) {
                    this.IP = response.data.ip;
                    this.coordinates = response.data.coordinates;
                    this.city = response.data.city;
                    this.region = response.data.region;
                    this.country = response.data.country;
                    this.seen = true;
                } else {
                    console.log('Error executing the request!');
                }
            });
        },
    }
};

Vue.createApp(SendThanks).mount('#geo-ip-block');