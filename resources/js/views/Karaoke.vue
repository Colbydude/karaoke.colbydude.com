<template>
    <div class="karaoke-container">
        <div id="player">
            <vue-plyr
                style="width: 100%; height: 100%;"
                :emit="['ended']"
                :key="currentRequest.video_name"
                :options="{ autoplay: false }"
                @ended="loadNextSong"
                v-if="requests.length > 0"
            >
                <div
                    data-plyr-provider="youtube"
                    :data-plyr-embed-id="currentRequest.youtube_link"
                />
            </vue-plyr>
        </div>
        <div class="queue">
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
    </div>
</template>

<script>
    export default {
        name: 'Karaoke',

        data() {
            return {
                requests: []    // Request queue.
            };
        },

        computed: {
            /**
             * The request at the top of the request queue.
             *
             * @return {SongRequest}
             */
            currentRequest() {
                if (this.requests.length < 1) {
                    return null;
                }

                return this.requests[0];
            },

            /**
             * The vue-plyr instance.
             *
             * @return {VuePlyr}
             */
            player() {
                return this.$refs.plyr.player;
            }
        },

        mounted() {
            // Fetch the request queue.
            this.fetchRequests();
        },

        methods: {
            /**
             * Delete the given request.
             *
             * @param  {SongRequest}  request
             * @return {Promise}
             */
            deleteRequest(request) {
                return axios.delete(`/api/song-requests/${request.id}`);
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
             * "Load" the next song by deleting the current request and refreshing the queue.
             *
             * @return {Void}
             */
            loadNextSong() {
                console.log(`${this.currentRequest.video_name} ended.`);

                this.deleteRequest(this.currentRequest)
                .then(() => this.fetchRequests())
                .catch(error => console.log);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .karaoke-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
    }

    #player {
        align-items: center;
        background-color: #333;
        display: flex;
        height: 75vh;
        justify-content: center;
        width: 100%;
    }

    .queue {
        background-color: #eee;
        height: 25vh;
        position: relative;
    }

    .queue-header {
        align-items: flex-end;
        display: flex;
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
        align-items: center;
        display: flex;
        flex-wrap: nowrap;
        height: calc(25vh - 40px);
        justify-content: flex-start;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 20px 40px;
        transform: translateZ(0);
        width: 100%;
    }

    .queue-item {
        align-items: center;
        background-color: white;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        font-size: 15px;
        height: 100%;
        justify-content: center;
        margin-right: 20px;
        min-width: 200px;
        padding: 20px;
        position: relative;
        text-align: center;
        width: 200px;

        &:first-child {
            margin-right: 40px;

            &::after {
                background-color: #ccc;
                content: "";
                display: block;
                height: 50%;
                position: absolute;
                right: -20px;
                top: 25%;
                width: 1px;
            }
        }

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
</style>
