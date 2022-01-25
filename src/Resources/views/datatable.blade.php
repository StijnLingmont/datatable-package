<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset("vendor/slingmont_datatable-package/css/app.css") }}" type="text/css">
<div id="datatable">
    <div class="filters">
        <div class="filter">
            <label for="search">Z</label>
            <input type="text" id="search" placeholder="Zoeken..." name="search">
        </div>
    </div>

    <div class="datatable_body">
        <table>
            <thead>
            <tr>
                @foreach($config['columns'] as $column)
                    <th>{{ $column['name'] }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody id="datatable-content">
            <tr v-for="row in rows">
                @foreach($config['columns'] as $column)
                    <td v-text="row.{{ $column['slug'] }}"></td>
                @endforeach
            </tr>
            </tbody>
        </table>
        <div class="loading" :class="{'visible': loading}">
            <div class="spinner">
                <span class="rect1" id="spin1"></span>
                <span class="rect1" id="spin2"></span>
                <span class="rect1" id="spin3"></span>
                <span class="rect1" id="spin4"></span>
                <span class="rect1" id="spin5"></span>
            </div>
        </div>
    </div>


    <div class="links">
        <div>
            <label v-text="'total: ' + total + ' | ' + from + ' - ' + to">0 | 0 - 0</label>
        </div>
        <div class="links_menu">
            <button class="prev-next-button" @click="navigate(page - 1)">Previous</button>
            <button class="page-button" @click="navigate(1)" v-if="calculatePagination(1) !== 1">1</button>
            <div class="links_navigation">
                <button class="page-button" v-for="index in amountOfLinks" :class="{ 'active': calculatePagination(index) === page }" v-if="calculatePagination(index) <= lastPage" v-text="calculatePagination(index)" @click="navigate(calculatePagination(index))"></button>
            </div>
            <button class="page-button" @click="navigate(lastPage)" v-if="calculatePagination(amountOfLinks) !== lastPage" v-text="lastPage"></button>
            <button class="prev-next-button" @click="navigate(page + 1)">Next</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
    var app = new Vue({
        el: '#datatable',
        data: {
            rows: [],
            loading: true,
            page: 1,
            from: 0,
            to: 0,
            total: 0,
            lastPage: 0,
            amountOfLinks: 5
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                var main = this;
                this.loading = true;

                axios.get('{{ $config['url'] }}?page=' + this.page)
                    .then(function (response) {
                        main.rows = response.data.data;
                        main.total = response.data.total;
                        main.from = response.data.from;
                        main.to = response.data.to;
                        main.lastPage = response.data.last_page;
                        main.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            navigate(newNumber) {
                if(newNumber > 0 && newNumber <= this.lastPage) {
                    this.page = newNumber;
                    this.getData();
                }
            },

            calculatePagination(index) {
                var newIndex = index;
                var middleItem = 2;
                var minCalculating = this.page - (this.amountOfLinks - middleItem);

                if(this.page > (this.lastPage - (this.amountOfLinks - middleItem))) {
                    return index + (this.lastPage - this.amountOfLinks);
                }

                if(minCalculating > 0) {
                    newIndex += minCalculating;
                }

                return newIndex;
            }
        }
    });
</script>
