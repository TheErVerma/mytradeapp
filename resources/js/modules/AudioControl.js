export default class AudioPlayer {
    constructor() {
        this.audioTag = document.getElementById('main_audio_player');
    }

    play(filePath) {
        const this_audio = this.audioTag;
        this_audio.src = filePath;
        this_audio.load();
        this_audio.play();
    }
}