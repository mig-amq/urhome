<template>
    <div class="container">
        <div class="row properties">
            <propertycard v-for="card in cards" v-bind:card="card" v-bind:key="card.PropertyID"></propertycard>
        </div>
    </div>
</template>

<script>
    import PropertyCard from './PropertyCard'

    export default {
        props: {
            cards: {
                type: Array,
                default: () => {return [];}
            }
        },
        data() {
            return {
                loading: false
            }
        },
        mounted() {
        },
        components: {
            'propertycard': PropertyCard
        }
    }
</script>