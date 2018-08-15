FONT_FILES := \
	dest/fonts/DSEG7Classic-RegularItalic.ttf \
	dest/fonts/DSEG7Classic-RegularItalic.otf \
	dest/fonts/DSEG7Classic-RegularItalic.woff \
	dest/fonts/DSEG7Classic-RegularItalic.woff2

CSS_FILES := \
	dest/DSEG7Classic-RegularItalic.min.css.br \
	dest/DSEG7Classic-RegularItalic.min.css.gz

DOC_FILES := DSEG-LICENSE.txt README.md

.PHONY: all clean dist-clean
all: $(FONT_FILES) $(CSS_FILES) $(DOC_FILES)

clean:
	rm -rf dest/*

dist-clean: clean
	rm -rf \
		src/*
		repo \
		$(DOC_FILES)

dest/fonts/%.ttf: src/fonts/%.ttf
	@mkdir -p $(dir $@)
	cp $< $@

dest/fonts/%.otf: src/fonts/%.otf
	@mkdir -p $(dir $@)
	cp $< $@

%.woff: %.ttf ../../node_modules
	../../node_modules/.bin/ttf2woff $< $@

%.woff2: %.ttf ../../node_modules
	../../node_modules/.bin/ttf2woff2 < $< > $@

.PRECIOUS: src/fonts/%.ttf
src/fonts/%.ttf: repo
	@mkdir -p $(dir $@)
	fontforge -lang=ff -c 'Open($$1); Generate($$2)' repo/src/$(basename $(notdir $@)).sfd $@

.PRECIOUS: src/fonts/%.otf
src/fonts/%.otf: repo
	@mkdir -p $(dir $@)
	fontforge -lang=ff -c 'Open($$1); Generate($$2)' repo/src/$(basename $(notdir $@)).sfd $@

$(DOC_FILES): repo
	cp repo/$(notdir $@) $@
	@chmod -x $@

repo:
	git clone https://github.com/keshikan/DSEG.git $@

.PRECIOUS: dest/%.css
dest/%.css: src/%.scss ../../node_modules
	../../node_modules/.bin/sass $< | ../../node_modules/.bin/postcss --no-map --use autoprefixer -o $@

.PRECIOUS: %.min.css
%.min.css: %.css ../../node_modules
	../../node_modules/.bin/postcss --no-map --use csswring -o $@ $<

%.gz: % ../../bin/zopfli
	@rm -f $@
	../../bin/zopfli -i50 --gzip -c $< > $@

%.br: % ../../bin/brotli
	@rm -f $@
	../../bin/brotli -kZ -o $@ $<
	@touch $@

../../node_modules:
	make -C ../.. node_modules

../../bin/zopfli:
	make -C ../../bin zopfli

../../bin/brotli:
	make -C ../../bin brotli
