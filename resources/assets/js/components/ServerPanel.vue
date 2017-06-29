<script>

    /**
     * This component is a single panel for a server. It handles the settings form and the delete
     * button.
     */

    export default {

        props: ['server'],

        data() {
            return {

                // Is the settings panel currently open?
                settingsOpen: false,

                // A copy of the servers' data
                data: this.server,

                // The input field (jQuery object)
                field: null,

                // The save button (jQuery object)
                saveBtn: null,

                // The cancel button (jQuery object)
                cancelBtn: null,

                // The original content of the save button
                originalSaveButtonContent: '',

                // Is this panel destroyed / deleted?
                destroyed: false

            };
        },

        watch: {

            /**
             * When the settings panel is opened or closed the google graph should resize itself
             */
            settingsOpen(val) {
                let self = this;
                setTimeout(function ()
                {
                    window['resizeChart_' + self.data.id]();
                }, 500);
            }

        },

        /**
         * When the component is mounted the necessary dependencies should be fetched.
         * Currently jQuery is used for it.
         */
        mounted() {
            this.field = $('#' + this.data.id + '_name');
            this.saveBtn = $('#' + this.data.id + '_save');
            this.cancelBtn = $('#' + this.data.id + '_cancel');
        },

        methods: {

            /**
             * Close or open the settings (toggle)
             */
            toggleSettings() {
                this.settingsOpen = !this.settingsOpen;
            },

            /**
             * Cancel the name changing. Reset the field and close the settings panel.
             */
            cancel() {
                let field = $('#' + this.data.id + '_name');
                field.val(this.data.name);

                this.settingsOpen = false;
            },

            /**
             * Save a new name for the server. So send a patch request to our api.
             */
            save() {
                this.originalSaveButtonContent = this.saveBtn.html();

                this.saveBtn.html('<span class="icon is-small"><i class="fa fa-circle-o-notch fa-spin"></i></span>&nbsp;Saving...');
                this.saveBtn.prop('disabled', true);
                this.cancelBtn.prop('disabled', true);

                axios.patch('/api/server', {
                    'token': this.data.token,
                    'name': this.field.val()
                }).then(() =>
                {
                    this.saveBtn.html(this.originalSaveButtonContent);
                    this.saveBtn.prop('disabled', false);
                    this.cancelBtn.prop('disabled', false);

                    this.data.name = this.field.val();
                    this.settingsOpen = false;
                }).catch(errors => this.onError(errors.response.data));
            },

            /**
             * If an error occured while saving the name it will be shown inside a sweet alert.
             *
             * @param errors
             */
            onError(errors)
            {
                let message = errors[Object.keys(errors)[0]][0];

                swal('Whoops!', message, 'error');

                this.saveBtn.html(this.originalSaveButtonContent);
                this.saveBtn.prop('disabled', false);
                this.cancelBtn.prop('disabled', false);
            },

            /**
             * Send a DELETE request to the api.
             */
            destroy()
            {
                let self = this;

                swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this server!',
                    type: 'warning',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    closeOnConfirm: false
                }, function ()
                {
                    console.dir(self.data.token);
                    axios.delete('/api/server', {
                        params: {token: self.data.token}
                    }).then(() =>
                    {
                        self.destroyed = true;

                        swal('Yeah!', 'The server is removed!', 'success');

                    }).catch(errors =>
                    {
                        self.originalSaveButtonContent = self.saveBtn.html();
                        self.onError(errors.response.data);
                    });
                });
            }

        }

    };

</script>