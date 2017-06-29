<script>
    export default {

        methods: {

            create() {

                let doubleName = chance().bool();
                let serverName = chance().word();

                if (doubleName) {
                    serverName += '.' + chance().word();
                }

                axios.post('/api/server', {
                    token: window.userToken,
                    name: serverName
                }).then(() => {
                    location.reload();
                });

            }

        }

    };
</script>