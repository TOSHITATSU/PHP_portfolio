// 音楽のaudio要素を取得する
const song = document.querySelector(".song");
// 再生/一時停止ボタンを取得する
const play = document.querySelector(".play");
// リプレイボタンを取得する
const replay = document.querySelector(".replay");
// アニメーションの輪郭線要素を取得する
const outline = document.querySelector(".moving-outline circle");
// ビデオ要素を取得する
const video = document.querySelector(".vid-container video");
// サウンドピッカーのボタンを取得する
const sounds = document.querySelectorAll(".sound-picker button");
// 時間表示要素を取得する
const timeDisplay = document.querySelector(".time-display");
// アニメーションの輪郭線の長さを取得する
const outlineLength = outline.getTotalLength();
// 音楽の再生時間を設定する
const timeSelect = document.querySelectorAll(".time-select button");
let fakeDuration = 1800;

/*
outline.style.strokeDashoffset = outlineLength; : outline という名前の要素（SVGの円形の輪郭線）の strokeDashoffset スタイルを outlineLength に設定しています。これは、SVG要素に線を描画するためのもので、SVG要素の長さを定義します。
outline.style.strokeDasharray = outlineLength; : outline 要素の strokeDasharray スタイルを outlineLength に設定しています。これは、SVG要素の線の長さを定義し、線の長さを指定することができます。これにより、outlineLength の値に基づいて、アニメーションの輪郭線が描画されます。
timeDisplay.textContent = ${Math.floor(fakeDuration / 60)}:${Math.floor(
fakeDuration % 60
)}; : timeDisplay 要素の textContent スタイルを、 Math.floor 関数を使用して fakeDuration（再生時間）を分と秒に分割し、 minutes:seconds の形式で設定しています。これにより、再生時間がユーザーに表示されます。
 */
outline.style.strokeDashoffset = outlineLength;
outline.style.strokeDasharray = outlineLength;
timeDisplay.textContent = `${Math.floor(fakeDuration / 60)}:${Math.floor(
  fakeDuration % 60
)}`;

// サウンドピッカーのクリックイベント処理
sounds.forEach(sound => {
  sound.addEventListener("click", function() {
    song.src = this.getAttribute("data-sound");
    video.src = this.getAttribute("data-video");
    checkPlaying(song);
  });
});

// 再生/一時停止ボタンのクリックイベント処理
play.addEventListener("click", function() {
  checkPlaying(song);
});

// リプレイするためのクリックイベント処理
replay.addEventListener("click", function() {
    restartSong(song); 
  });
  const restartSong = song =>{
  let currentTime = song.currentTime;
  song.currentTime = 0;
  console.log("ciao")
}

//HTMLの各時間選択処理
timeSelect.forEach(option => {
  option.addEventListener("click", function() {
    fakeDuration = this.getAttribute("data-time");
    timeDisplay.textContent = `${Math.floor(fakeDuration / 60)}:${Math.floor(
      fakeDuration % 60
    )}`;
  });
});

const checkPlaying = song => {
  if (song.paused) {
    song.play();
    video.play();
    play.src = "./svg/pause.svg";
  } else {
    song.pause();
    video.pause();
    play.src = "./svg/play.svg";
  }
};

song.ontimeupdate = function() {
  let currentTime = song.currentTime;
  let elapsed = fakeDuration - currentTime;
  let seconds = Math.floor(elapsed % 60);
  let minutes = Math.floor(elapsed / 60);
  timeDisplay.textContent = `${minutes}:${seconds}`;
  let progress = outlineLength - (currentTime / fakeDuration) * outlineLength;
  outline.style.strokeDashoffset = progress;

  if (currentTime >= fakeDuration) {
    song.pause();
    song.currentTime = 0;
    play.src = "./svg/play.svg";
    video.pause();
  }
};