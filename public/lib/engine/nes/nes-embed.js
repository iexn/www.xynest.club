var SCREEN_WIDTH = 256;
var SCREEN_HEIGHT = 240;
var FRAMEBUFFER_SIZE = SCREEN_WIDTH*SCREEN_HEIGHT;

var canvas_ctx, image;
var framebuffer_u8, framebuffer_u32;

var AUDIO_BUFFERING = 512;
var SAMPLE_COUNT = 4*1024;
var SAMPLE_MASK = SAMPLE_COUNT - 1;
var audio_samples_L = new Float32Array(SAMPLE_COUNT);
var audio_samples_R = new Float32Array(SAMPLE_COUNT);
var audio_write_cursor = 0, audio_read_cursor = 0;

var VELOCITY = 16.666667;
var SPEED    = 1;

var nes = new jsnes.NES({
	onFrame: function(framebuffer_24){
		for(var i = 0; i < FRAMEBUFFER_SIZE; i++) framebuffer_u32[i] = 0xFF000000 | framebuffer_24[i];
	},
	onAudioSample: function(l, r){
		audio_samples_L[audio_write_cursor] = l;
		audio_samples_R[audio_write_cursor] = r;
		audio_write_cursor = (audio_write_cursor + 1) & SAMPLE_MASK;
	},
});

function onAnimationFrame(){
	window.requestAnimationFrame(onAnimationFrame);
	// window.setTimeout(onAnimationFrame, VELOCITY * SPEED);

	image.data.set(framebuffer_u8);
	canvas_ctx.putImageData(image, 0, 0);
	nes.frame();
}

function audio_remain(){
	return (audio_write_cursor - audio_read_cursor) & SAMPLE_MASK;
}

function audio_callback(event){
	var dst = event.outputBuffer;
	var len = dst.length;

	// Attempt to avoid buffer underruns.
	try {
		if(audio_remain() < AUDIO_BUFFERING) nes.frame();
	} catch(e) {}

	var dst_l = dst.getChannelData(0);
	var dst_r = dst.getChannelData(1);
	for(var i = 0; i < len; i++){
		var src_idx = (audio_read_cursor + i) & SAMPLE_MASK;
		dst_l[i] = audio_samples_L[src_idx];
		dst_r[i] = audio_samples_R[src_idx];
	}

	audio_read_cursor = (audio_read_cursor + len) & SAMPLE_MASK;
}

var UNINTERRUPTED_BUTTON_A_ST = null;
var UNINTERRUPTED_BUTTON_A_DOWN = false;
var UNINTERRUPTED_BUTTON_B_ST = null;
var UNINTERRUPTED_BUTTON_B_DOWN = false;

function keyboard(callback, event){
	var player = 1;
	switch(event.keyCode){
		case 87: // UP
			callback(player, jsnes.Controller.BUTTON_UP); break;
		case 83: // Down
			callback(player, jsnes.Controller.BUTTON_DOWN); break;
		case 65: // Left
			callback(player, jsnes.Controller.BUTTON_LEFT); break;
		case 68: // Right
			callback(player, jsnes.Controller.BUTTON_RIGHT); break;
		// case 65: // 'a' - qwerty, dvorak
		case 75: // 'q' - azerty
			callback(player, jsnes.Controller.BUTTON_A); break;
		// case 83: // 's' - qwerty, azerty
		case 74: // 'o' - dvorak
			callback(player, jsnes.Controller.BUTTON_B); break;
		case 50: // Tab
			callback(player, jsnes.Controller.BUTTON_SELECT); break;
		case 49: // Return
			callback(player, jsnes.Controller.BUTTON_START); break;
		case 85: // uninterrupted b, U
			if(callback == nes.buttonUp) {
				clearInterval(UNINTERRUPTED_BUTTON_B_ST);
				UNINTERRUPTED_BUTTON_B_DOWN = false;
				return ;
			}

			if(UNINTERRUPTED_BUTTON_B_DOWN == false) {
				callback(player, jsnes.Controller.BUTTON_B);
				nes.buttonUp(player, jsnes.Controller.BUTTON_B);
				
				UNINTERRUPTED_BUTTON_B_ST = setInterval(function () {
					callback(player, jsnes.Controller.BUTTON_B);
					setTimeout(function () {
						nes.buttonUp(player, jsnes.Controller.BUTTON_B);
					}, 40);
				}, 80);

				UNINTERRUPTED_BUTTON_B_DOWN = true;
			}
			
		break;
		case 73: // uninterrupted a, I
			if(callback == nes.buttonUp) {
				clearInterval(UNINTERRUPTED_BUTTON_A_ST);
				UNINTERRUPTED_BUTTON_A_DOWN = false;
				return ;
			}

			if(UNINTERRUPTED_BUTTON_A_DOWN == false) {
				callback(player, jsnes.Controller.BUTTON_A);
				nes.buttonUp(player, jsnes.Controller.BUTTON_A);
				
				UNINTERRUPTED_BUTTON_A_ST = setInterval(function () {
					callback(player, jsnes.Controller.BUTTON_A);
					setTimeout(function () {
						nes.buttonUp(player, jsnes.Controller.BUTTON_A);
					}, 40);
				}, 80);

				UNINTERRUPTED_BUTTON_A_DOWN = true;
			}
			
		break;
		default: break;
	}
}

function nes_init(canvas_id){
	var canvas = document.getElementById(canvas_id);
	canvas.width = 256;
	canvas.height = 240;

	canvas_ctx = canvas.getContext("2d");
	image = canvas_ctx.getImageData(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

	canvas_ctx.fillStyle = "black";
	canvas_ctx.fillRect(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

	// Allocate framebuffer array.
	var buffer = new ArrayBuffer(image.data.length);
	framebuffer_u8 = new Uint8ClampedArray(buffer);
	framebuffer_u32 = new Uint32Array(buffer);

	// Setup audio.
	var audio_ctx = new window.AudioContext();
	var script_processor = audio_ctx.createScriptProcessor(AUDIO_BUFFERING, 0, 2);
	script_processor.onaudioprocess = audio_callback;
	script_processor.connect(audio_ctx.destination);
}

function nes_boot(rom_data){
	nes.loadROM(rom_data);
	window.requestAnimationFrame(onAnimationFrame);
	// window.setTimeout(onAnimationFrame, VELOCITY * SPEED);
}

function nes_load_data(canvas_id, rom_data){
	nes_init(canvas_id);
	nes_boot(rom_data);
}

function nes_load_url(canvas_id, path){
	nes_init(canvas_id);

	var req = new XMLHttpRequest();
	req.open("GET", path);
	req.overrideMimeType("text/plain; charset=x-user-defined");
	req.onerror = () => console.log(`Error loading ${path}: ${req.statusText}`);

	req.onload = function() {
		if (this.status === 200) {
		nes_boot(this.responseText);
		} else if (this.status === 0) {
			// Aborted, so ignore error
		} else {
			req.onerror();
		}
	};

	req.send();
}

document.addEventListener('keydown', (event) => {keyboard(nes.buttonDown, event)});
document.addEventListener('keyup', (event) => {keyboard(nes.buttonUp, event)});

//
var self = this;

self.updateStatus = function (text) {
	document.querySelector('.fps').innerHTML = text || '';
}

// 显示帮助
document.querySelector('.controls-view').addEventListener('click', function () {
	var control_info = document.querySelector('.control-info');
	if (control_info.style.display != 'block') {
		control_info.style.display = 'block';
	} else {
		control_info.style.display = 'none';
	}
});

// 检测帧数
setInterval(function () {
	self.updateStatus((nes.getFPS() || 0).toFixed(0) + 'FPS');
}, 1000);
