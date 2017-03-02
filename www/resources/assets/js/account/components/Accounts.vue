<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="socials" v-if="getSocialsCount() == 0">
                <h3>No connected socials. Press plus button to add.</h3>
            </div>
            <div class="socials" v-else>
                <h2>Here connected socials. Press plust to add more.</h2>
            </div>

            <div class="plus-button">
                <button class="btn btn-sq-sm btn-primary add-button" @click="handlePlus()">
                    <i class="fa fa-plus fa-2x"></i><br/>
                </button>
            </div>

            <div v-if="isOpened()">
                <br><label>test</label>
            </div>
        </div>
    </div>
</template>

<style>
    .panel-body {
        min-height: 150px;
    }
</style>

<script>

    export default {
        data : function() {
            return {
                plusButton: false,
                socials: [1]
            }
        },

        mounted() {
            console.log("Accounts component mounted.")
        },

        methods : {
            handlePlus() {
                this.plusButton = !this.plusButton
            },

            isOpened() {
                return this.plusButton
            },

            getSocialsCount() {
                return this.socials.length
            }
        }
    }

</script>