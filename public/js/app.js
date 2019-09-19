
// Componente para mostras as fotos
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
                <img :src="photo.url" class="img-thumbnail">
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
        // Pega o preço baseado no tamanho
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

// Handler da aplicação do Vue.js
var app = new Vue ({
    el: '#app',
    data: {
        requestUrl: 'http://localhost:8000/api/photo/',
        photosReaded: [],
        photosReadedTotal: 0
    },
    methods: {
        // Pega todas as fotos
        getPhotosData: function () {
            
            for (var i = 1; i <= this.photosReadedTotal; i++) {
                axios.get(this.requestUrl + i)
                    .then(response => {
                        this.photosReaded.push({"url":response.data.url, "sizes":response.data.sizes, "copies":response.data.copies});
                });
            }

        },
        // Pega a quantidade de fotos no banco de dados
        getPhotosSize: function () {
            
            axios.get(this.requestUrl)
            .then(response => {
                console.log(response);
                this.photosReadedTotal = response.data.size;
            });

        }
    },
});