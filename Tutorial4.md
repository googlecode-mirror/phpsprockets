Sprockets are fairly straightforward tools; the idiosyncracies they have are reflections of the idiosyncracies of HTML and XML. Here are some of the more prevalent gotchas:

  * If a Sprocket has no content - no text or sprockets inside, it will render as a **short tag**, such as <br />. This can occasionally be confusing if you want to render an empty div; <div /> is not valid HTML.

  * If you want to have an **empty fully formed tag**, such as <div></div>, create it with an empty string ('').

  * Sprockets can't make **DTD declarations**; they are just too weird. You can add them as text, of course.

  * You can make **'headless' Sprockets** by omitting the tagname when you create it. It will render any Sprockets or text it contains, but not any enclosing tag or attributes. This could be useful if you were rendering, say, an Atom feed in parts.

  * Sprockets are great for **generating XML**. The only problem you'll find is the colons in XSL tags (XSL will require a new subclass of Sprockets capable of using namespaces).