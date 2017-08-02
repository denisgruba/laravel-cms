<div v-if="fetchingData">
    <div v-if="fetchingFailed">
        <div class="card-panel">
            @{{this.fetchingError}}
        </div>
    </div>
    <div v-else>
        @include('partials.preloader-animation')
    </div>
</div>
