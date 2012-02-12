//	JS API 2.0 для Uppod 1+ http://uppod.ru/player/js

	// события - http://uppod.ru/player/js#events
	
	function uppodEvent(playerID,event) { 
	
		TestEvents(event); // для демонстрации (можно удалить)
		switch(event){
		
			case 'init': // загрузка
			
				break;
				
			case 'start': // старт
				
				break;
			
			case 'play': // пуск
				
				break;
				
			case 'pause': // пауза
				
				break;
				
			case 'stop': // стоп
				
				break;
				
			case 'seek': // перемотка
				
				break;
				
			case 'loaded': // перемотка
				
				break;
				
			case 'end': // конец воспроизведения
				
				break;
				
			case 'download': // скачивание
				
				break;
				
			case 'quality': // переключение качества
				
				break;
			
			case 'error': // ошибка (файл не найден)
				
				break;
					
			case 'ad_end': // окончание рекламы
				
				break;
				
			case 'pl': // загрузка плейлиста
				
				break;
		}
		
	}
	
	// команды - http://uppod.ru/player/js#send
	
	function uppodSend(playerID,com,callback) {
		document.getElementById(playerID).sendToUppod(com);
	}
	
	// запросы - http://uppod.ru/player/js#get
	
	function uppodGet(playerID,com,callback) {
		return document.getElementById(playerID).getUppod(com);
	}

