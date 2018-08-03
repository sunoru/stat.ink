MY_BIN_DIR := ../../bin
ZOPFLI_BIN := $(MY_BIN_DIR)/zopfli
BROTLI_BIN := $(MY_BIN_DIR)/brotli

NODE_DIR := ../../node_modules
NODE_BIN_DIR := $(NODE_DIR)/.bin

ES_SOURCE_FILES := $(shell ls -1 src/*.es)
JS_TARGET_FILES := $(addprefix dest/,$(notdir $(ES_SOURCE_FILES:.es=.min.js)))

TARGETS := \
	$(JS_TARGET_FILES) \
	$(JS_TARGET_FILES:=.br) \
	$(JS_TARGET_FILES:=.gz)

.PHONY: all clean
.PRECIOUS: dest/%.js

all: $(TARGETS)

clean:
	rm -f dest/*

dest/%.js: src/%.es $(NODE_DIR)
	$(NODE_BIN_DIR)/babel -o $@ $<

%.min.js: %.js $(NODE_DIR)
	$(NODE_BIN_DIR)/uglifyjs -c -m -b beautify=false,ascii_only=true --comments -o $@ $<

%.gz: % $(ZOPFLI_BIN)
	@rm -f $@
	$(ZOPFLI_BIN) -i50 --gzip -c $< > $@

%.br: % $(BROTLI_BIN)
	@rm -f $@
	$(BROTLI_BIN) -kZ -o $@ $<

$(ZOPFLI_BIN):
	make -C $(MY_BIN_DIR) zopfli

$(BROTLI_BIN):
	make -C $(MY_BIN_DIR) brotli

$(NODE_DIR):
	make -C ../.. node_modules
