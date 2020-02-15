<template>
    <div class="requests-container">
        <header>
            Karaoke
            <button @click.prevents="toggleForm">
                <font-awesome-icon class="fa-fw" icon="plus" v-if="!showForm" />
                <font-awesome-icon class="fa-fw" icon="times" v-else />
            </button>
        </header>
        <div class="queue" v-if="!showForm">
            <div class="queue-header">
                <span class="queue-header-count">{{ requests.length }}</span>
                <span>Song Queue</span>
            </div>
            <div class="queue-content">
                <div class="queue-item" v-for="request in requests">
                    <h3>{{ request.video_name }}</h3>
                    <span>Requested by</span>
                    <h5>{{ request.name }}</h5>
                </div>
            </div>
        </div>
        <div class="request-form" v-else>
            <form @submit.prevent="addRequest">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" name="name" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="youtube_link">YouTube Link:</label>
                    <input type="text" name="youtube_link" class="form-control" required />
                </div>

                <button class="btn btn-primary" type="submit">Request</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Requests',

        data() {
            return {
                name: '',
                requests: [],
                showForm: false,
                youtube_link: ''
            };
        },

        mounted() {
            // Listen for pusher events for when requests are added.
            Echo.channel('requests')
            .listen('SongRequestCreated', () => this.fetchRequests())
            .listen('SongRequestDeleted', () => this.fetchRequests())
            .listen('SongRequestsCleared', () => this.fetchRequests());

            // Fetch the request queue.
            this.fetchRequests();
        },

        methods: {
            /**
             * Add a request to the queue.
             *
             * @return {Void}
             */
            addRequest() {
                // @TODO: Validate YouTube link.
                //        Determine video name from link.
                //        POST to API.

                this.name = '';
                this.youtube_link = '';
            },

            /**
             * Fetch the request queue and bind the player ended event.
             *
             * @return {Void}
             */
            fetchRequests() {
                axios.get('/api/song-requests')
                .then(response => {
                    this.requests = response.data;
                })
                .catch(error => console.log);
            },

            /**
             * Toggles the showForm state.
             *
             * @return {Void}
             */
            toggleForm() {
                this.showForm = !this.showForm;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .requests-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
    }

    header {
        align-items: center;
        background-color: #e54c72;
        color: white;
        display: flex;
        font-size: 30px;
        font-weight: bold;
        height: 50px;
        line-height: 1;
        padding: 20px;
        width: 100%;

        button {
            background-color: darken(#e54c72, 15%);
            border: none;
            color: white;
            position: absolute;
            right: 15px;
        }
    }

    .queue {
        background-color: #eee;
        display: flex;
        flex: 1 0 0;
        flex-direction: column;
        transform: translateZ(0);
    }

    .queue-header {
        align-items: center;
        display: flex;
        flex-shrink: 0;
        height: 40px;
        justify-content: flex-start;
        padding-left: 20px;
        width: 100%;
    }

    .queue-header-count {
        background-color: #e54c72;
        border-radius: 50px;
        color: white;
        font-size: 13px;
        height: 25px;
        line-height: 1;
        margin-right: 10px;
        padding-top: 5px;
        text-align: center;
        width: 25px;
    }

    .queue-content {
        height: calc(100vh - 90px);
        overflow-y: auto;
    }

    .queue-item {
        background-color: white;
        border-bottom: 1px solid #f0f0f0;
        font-size: 15px;
        padding: 10px 20px;
        position: relative;
        text-align: left;

        h3 {
            font-size: 16px;
            font-weight: normal;
            margin-bottom: .3rem;
        }

        h5 {
            font-size: 0.83em;
            font-weight: normal;
        }

        span {
            color: #ccc;
            display: block;
            font-size: .8rem;
            margin: 5px 0;
        }
    }

    .request-form {
        padding: 20px;
    }
</style>
