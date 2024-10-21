function initQuill(selector, placeholderText) {
  return new Quill(selector, {
    theme: "snow",
    placeholder: placeholderText,
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ["bold", "italic", "underline"],
        ["link", "blockquote", "code-block"],
        [{ list: "ordered" }, { list: "bullet" }],
      ],
    },
  });
}
