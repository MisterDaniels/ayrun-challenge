
Vue.component('photo-image', {
    props: {
        photo: {
            type: Object,
            required: true,
        }
    },
    data: function () {
        return {
            
        }
    },
    template:
        `<div class="row mt-5">
            <div class="col-sm">
                <img src="https://image.shutterstock.com/image-photo/colorful-flower-on-dark-tropical-260nw-721703848.jpg" class="img-thumbnail">
            </div>
            <div class="col-sm">
                <h3 id="image-url">{{ photo.url }}</h3>
                <p v-for="size in photo.sizes">
                    {{ size.toString() }} | R$ {{ getPrice(size) }}
                </p>
                <h4>{{ photo.copies }} cópias</h4>
            </div>
        </div>`
    ,
    methods: {
        getPrice: function (size) {
            switch(size.toString()) {
                case "10x15":
                    return 0.10 * this.photo.copies;
                case "12x15":
                    return 0.15 * this.photo.copies;
                case "13x18":
                    return 0.20 * this.photo.copies;
                default: 
                    return 0 * this.photo.copies;
            }
        }
    }
});

var app = new Vue ({
    el: '#app',
    data: {
        requestUrl: 'http://localhost:8000/api/photo/',
        photosReaded: [],
        photosReadedTotal: 0
    },
    methods: {
        getPhotosData: function (id) {
            
            axios.get(this.requestUrl + id)
                .then(response => {
                    console.log(response.data);
                    for (var i = 0; i < this.photosReadedTotal; i++) {
                        this.photosReaded.push({"url":response.data.url, "sizes":response.data.sizes, "copies":response.data.copies});
                    }
            });

        },
        getPhotosSize: function (id) {
            
            axios.get(this.requestUrl)
            .then(response => {
                console.log(response);
                this.photosReadedTotal = response.data.size;
            });

        }
    },
});