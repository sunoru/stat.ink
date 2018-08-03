.PHONY: all	
all: brotli zopfli

clean:
	rm -f brotli zopfli

brotli:
	curl -sL -o $@ 'https://github.com/fetus-hina/static-builds/raw/master/bin/brotli'
	chmod +x $@

zopfli:
	curl -sL -o $@ 'https://github.com/fetus-hina/static-builds/raw/master/bin/zopfli'
	chmod +x $@
