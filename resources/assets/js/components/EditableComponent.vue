<template>
    <div contenteditable="true" @input="update" class="b_pageEditor_e_content mt-1"></div>
</template>

<script>
    export default {
        props:['text'],
        data() {
            return {
                'currentText': null
            };
        },
        watch: {
            text: function (newValue, oldValue) {
                if(newValue !== this.currentText) {
                    this.updateContent();
                }
            },
        },

        mounted() {
            this.updateContent();
        },
        methods: {
            updateContent() {
                this.currentText = this.text;
                this.$el.innerText = this.currentText;
            },
            update(event) {
                this.currentText = event.target.innerText;
                this.$emit('update', this.currentText);
            }
        }
    }
</script>
