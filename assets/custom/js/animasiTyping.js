// JavaScript untuk menerapkan animasi ketikan
const texts = ['Input Username', 'Masukan Username', 'Asupan Username'];
const input = document.querySelector('#username');
let aw = null;

class AnimationWorker {
  constructor(input, texts) {
    this.input = input;
    this.defaultPlaceholder = this.input.getAttribute('placeholder');
    this.texts = texts;
    this.curTextNum = 0;
    this.curPlaceholder = '';
    this.blinkCounter = 0;
    this.animationFrameId = 0;
    this.animationActive = false;
    this.input.setAttribute('placeholder', this.curPlaceholder);

    this.switch = (timeout) => {
      this.input.classList.add('imitatefocus');
      setTimeout(() => {
        this.input.classList.remove('imitatefocus');
        if (this.curTextNum === 0)
          this.input.setAttribute('placeholder', this.defaultPlaceholder);
        else
          this.input.setAttribute('placeholder', this.curPlaceholder);

        setTimeout(() => {
          this.input.setAttribute('placeholder', this.curPlaceholder);
          if (this.animationActive)
            this.animationFrameId = window.requestAnimationFrame(this.animate);
        }, timeout);
      }, timeout);
    };

    this.animate = () => {
      if (!this.animationActive) return;
      let curPlaceholderFullText = this.texts[this.curTextNum];
      let timeout = 100;
      if (this.curPlaceholder == curPlaceholderFullText + '|' && this.blinkCounter == 3) {
        this.blinkCounter = 0;
        this.curTextNum = (this.curTextNum >= this.texts.length - 1) ? 0 : this.curTextNum + 1;
        this.curPlaceholder = '|';
        this.switch(150);
        return;
      } else if (this.curPlaceholder == curPlaceholderFullText + '|' && this.blinkCounter < 3) {
        this.curPlaceholder = curPlaceholderFullText;
        this.blinkCounter++;
      } else if (this.curPlaceholder == curPlaceholderFullText && this.blinkCounter < 3) {
        this.curPlaceholder = this.curPlaceholder + '|';
      } else {
        this.curPlaceholder = curPlaceholderFullText
          .split('')
          .slice(0, this.curPlaceholder.length + 1)
          .join('') + '|';
        timeout = 150;
      }
      this.input.setAttribute('placeholder', this.curPlaceholder);
      setTimeout(() => {
        if (this.animationActive)
          this.animationFrameId = window.requestAnimationFrame(this.animate);
      }, timeout);
    };

    this.stop = () => {
      this.animationActive = false;
      window.cancelAnimationFrame(this.animationFrameId);
    };

    this.start = () => {
      this.animationActive = true;
      this.animationFrameId = window.requestAnimationFrame(this.animate);
      return this;
    };
  }
}

document.addEventListener("DOMContentLoaded", () => {
  aw = new AnimationWorker(input, texts).start();
  input.addEventListener("focus", (e) => aw.stop());
  input.addEventListener("blur", (e) => {
    aw = new AnimationWorker(input, texts);
    if (e.target.value === '') setTimeout(aw.start, 100);
  });
});