MY_BIN_DIR := ../../bin
ZOPFLI_BIN := $(MY_BIN_DIR)/zopfli
BROTLI_BIN := $(MY_BIN_DIR)/brotli

NODE_DIR := ../../node_modules
NODE_BIN_DIR := $(NODE_DIR)/.bin

ES_SOURCE_FILES := $(shell ls -1 src/*.es)
JS_TARGET_FILES := $(addprefix dest/,$(notdir $(ES_SOURCE_FILES:.es=.min.js)))

SCSS_SOURCE_FILES := $(shell ls -1 src/*.scss)
CSS_TARGET_FILES := $(addprefix dest/,$(notdir $(SCSS_SOURCE_FILES:.scss=.min.css)))

TARGETS := \
	$(CSS_TARGET_FILES) \
	$(CSS_TARGET_FILES:=.br) \
	$(CSS_TARGET_FILES:=.gz) \
	$(JS_TARGET_FILES) \
	$(JS_TARGET_FILES:=.br) \
	$(JS_TARGET_FILES:=.gz)

.PHONY: all clean
.PRECIOUS: dest/%.js dest/%.css

all: $(TARGETS)

clean:
	rm -f dest/*

dest/%.js: src/%.es $(NODE_DIR)
	$(NODE_BIN_DIR)/babel -o $@ $<

%.min.js: %.js $(NODE_DIR)
	$(NODE_BIN_DIR)/uglifyjs -c -m -b beautify=false,ascii_only=true --comments -o $@ $<

dest/%.css: src/%.scss $(NODE_DIR)
	$(NODE_BIN_DIR)/sass $< | $(NODE_BIN_DIR)/postcss --no-map --use autoprefixer -o $@

%.min.css: %.css $(NODE_DIR)
	$(NODE_BIN_DIR)/postcss --no-map --use csswring -o $@ $<

%.gz: % $(ZOPFLI_BIN)
	@rm -f $@
	$(ZOPFLI_BIN) -i50 --gzip -c $< > $@

%.br: % $(BROTLI_BIN)
	@rm -f $@
	$(BROTLI_BIN) -kZ -o $@ $<
	@touch $@

$(ZOPFLI_BIN):
	make -C $(MY_BIN_DIR) zopfli

$(BROTLI_BIN):
	make -C $(MY_BIN_DIR) brotli

$(NODE_DIR):
	make -C ../.. node_modules
