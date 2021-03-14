<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <p>
                            I'm an example component.
                        </p>
                        <button @click="getCart" class="btn btn-default mb-1">Get Cart</button>
                        <p>Товаров - {{cart.amount}}</p>
                        <p>Стоимость - {{cart.cost_total}}</p>
                        <p>Валюта - {{cart.signature}}</p>
                        <ul>
                            <li v-for="item in cart.items">{{item.product_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data: function(){
            return {
                cart: []
            }
        },
        computed: {
            carts() {
                return this.$store.getters.getCart
            },
            cartCount() {
                return this.$store.getters.getCartCount
            }
        },
        mounted() {
            console.log('Component mounted.')
            console.log(this.data)
            console.log(this.$store.state.cart.cart)
            console.log(this.$store.state.cart.cartCount)
            console.log(this.carts)
            console.log(this.cartCount)
            //this.getCart()
        },
        methods: {
            getCart: function () {
                axios.get('/ajax/cart-ajax')
                    .then((response) => {
                        console.log(response.data)
                        this.cart = response.data
                    });
            }
        }
    }
</script>
