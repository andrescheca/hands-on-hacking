var __create = Object.create;
var __defProp = Object.defineProperty;
var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
var __getOwnPropNames = Object.getOwnPropertyNames;
var __getProtoOf = Object.getPrototypeOf, __hasOwnProp = Object.prototype.hasOwnProperty;
var __export = (target, all) => {
  for (var name in all)
    __defProp(target, name, { get: all[name], enumerable: !0 });
}, __copyProps = (to, from, except, desc) => {
  if (from && typeof from == "object" || typeof from == "function")
    for (let key of __getOwnPropNames(from))
      !__hasOwnProp.call(to, key) && key !== except && __defProp(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc(from, key)) || desc.enumerable });
  return to;
};
var __toESM = (mod, isNodeMode, target) => (target = mod != null ? __create(__getProtoOf(mod)) : {}, __copyProps(
  isNodeMode || !mod || !mod.__esModule ? __defProp(target, "default", { value: mod, enumerable: !0 }) : target,
  mod
)), __toCommonJS = (mod) => __copyProps(__defProp({}, "__esModule", { value: !0 }), mod);

// <stdin>
var stdin_exports = {};
__export(stdin_exports, {
  assets: () => assets_manifest_default,
  assetsBuildDirectory: () => assetsBuildDirectory,
  entry: () => entry,
  publicPath: () => publicPath,
  routes: () => routes
});
module.exports = __toCommonJS(stdin_exports);

// app/entry.server.tsx
var entry_server_exports = {};
__export(entry_server_exports, {
  default: () => handleRequest
});
var import_stream = require("stream"), import_node = require("@remix-run/node"), import_react = require("@remix-run/react"), import_isbot = __toESM(require("isbot")), import_server = require("react-dom/server"), import_jsx_runtime = require("react/jsx-runtime"), ABORT_DELAY = 5e3;
function handleRequest(request, responseStatusCode, responseHeaders, remixContext) {
  let callbackName = (0, import_isbot.default)(request.headers.get("user-agent")) ? "onAllReady" : "onShellReady";
  return new Promise((resolve, reject) => {
    let didError = !1, { pipe, abort } = (0, import_server.renderToPipeableStream)(
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react.RemixServer, {
        context: remixContext,
        url: request.url
      }),
      {
        [callbackName]: () => {
          let body = new import_stream.PassThrough();
          responseHeaders.set("Content-Type", "text/html"), resolve(
            new import_node.Response(body, {
              headers: responseHeaders,
              status: didError ? 500 : responseStatusCode
            })
          ), pipe(body);
        },
        onShellError: (err) => {
          reject(err);
        },
        onError: (error) => {
          didError = !0, console.error(error);
        }
      }
    );
    setTimeout(abort, ABORT_DELAY);
  });
}

// app/root.tsx
var root_exports = {};
__export(root_exports, {
  default: () => App,
  links: () => links,
  loader: () => loader,
  meta: () => meta
});
var import_node2 = require("@remix-run/node"), import_react5 = require("@remix-run/react");

// app/styles/tailwind.css
var tailwind_default = "/build/_assets/tailwind-TC4XURZ3.css";

// app/root.tsx
var import_free_regular_svg_icons = require("@fortawesome/free-regular-svg-icons"), import_react_fontawesome2 = require("@fortawesome/react-fontawesome"), import_react6 = require("react"), import_react7 = require("@headlessui/react");

// app/utils.ts
function classNames(...classes) {
  return classes.filter(Boolean).join(" ");
}

// app/db.server.ts
var import_client = require("@prisma/client"), prisma;
prisma = new import_client.PrismaClient();

// app/models/chapter.server.ts
function getChapter({ index }) {
  return prisma.chapter.findFirst({
    where: { index }
  });
}
function getChapters() {
  return prisma.chapter.findMany({
    select: {
      id: !0,
      title: !0,
      index: !0,
      menuTitle: !0,
      containerName: !0,
      composerFileLocation: !0
    },
    orderBy: { index: "asc" }
  });
}

// app/components/MachineStatusIcon.tsx
var import_jsx_runtime = require("react/jsx-runtime"), MachineStatusIcon = ({
  isRunning,
  hideStoppedState = !1
}) => {
  let canShowSmallIcon = isRunning || !hideStoppedState;
  return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
    className: "relative flex h-3 w-3 items-center justify-center",
    children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", {
        className: classNames(
          isRunning ? "bg-green-200 motion-safe:animate-ping-slow" : "",
          "absolute h-full w-full rounded-full opacity-75"
        )
      }),
      canShowSmallIcon && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", {
        className: classNames(
          isRunning ? "bg-green-500" : "bg-red-500",
          "absolute h-2 w-2 rounded-full"
        )
      })
    ]
  });
}, MachineStatusIcon_default = MachineStatusIcon;

// app/root.tsx
var import_docker_cli_js = require("docker-cli-js"), import_free_solid_svg_icons2 = require("@fortawesome/free-solid-svg-icons");

// app/components/CommandPalette.tsx
var import_react2 = require("react"), import_react3 = require("@headlessui/react"), import_react_fontawesome = require("@fortawesome/react-fontawesome"), import_free_solid_svg_icons = require("@fortawesome/free-solid-svg-icons");
var import_react4 = require("@remix-run/react"), import_jsx_runtime = require("react/jsx-runtime");
function CommandPalette({
  chapters
}) {
  let [query, setQuery] = (0, import_react2.useState)(""), [open, setOpen] = (0, import_react2.useState)(!1), navigate = (0, import_react4.useNavigate)();
  (0, import_react2.useEffect)(() => {
    let onKeydown = (e) => {
      e.key === "Escape" ? setOpen(!1) : e.key === "k" && (e.metaKey || e.ctrlKey) && setOpen(!open);
    };
    return window.addEventListener("keydown", onKeydown), () => {
      window.removeEventListener("keydown", onKeydown);
    };
  }, [open]);
  let filteredChapters = query === "" ? [] : chapters.filter((chapter) => chapter.name.toLowerCase().includes(query.toLowerCase()));
  return /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Transition.Root, {
    show: open,
    as: import_react2.Fragment,
    afterLeave: () => setQuery(""),
    appear: !0,
    children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react3.Dialog, {
      as: "div",
      className: "relative z-50",
      onClose: setOpen,
      children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Transition.Child, {
          as: import_react2.Fragment,
          enter: "ease-out duration-300",
          enterFrom: "opacity-0",
          enterTo: "opacity-100",
          leave: "ease-in duration-200",
          leaveFrom: "opacity-100",
          leaveTo: "opacity-0",
          children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
            className: "fixed inset-0 bg-black bg-opacity-75 transition-opacity"
          })
        }),
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
          className: "fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20",
          children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Transition.Child, {
            as: import_react2.Fragment,
            enter: "ease-out duration-300",
            enterFrom: "opacity-0 scale-95",
            enterTo: "opacity-100 scale-100",
            leave: "ease-in duration-200",
            leaveFrom: "opacity-100 scale-100",
            leaveTo: "opacity-0 scale-95",
            children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react3.Dialog.Panel, {
              as: "fieldset",
              className: "fieldset mx-auto max-w-xl transform overflow-hidden rounded-xl bg-black transition-all",
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                  className: "legend",
                  children: "Command Palette"
                }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react3.Combobox, {
                  onChange: (chapter) => {
                    setOpen(!1), navigate(`/${chapter.href}`);
                  },
                  children: [
                    /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                      className: "relative -mt-1",
                      children: [
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome.FontAwesomeIcon, {
                          icon: import_free_solid_svg_icons.faSearch,
                          className: "pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-green-500",
                          "aria-hidden": "true"
                        }),
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Combobox.Input, {
                          className: "placholder h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-300 placeholder-gray-500 outline-none sm:text-sm",
                          placeholder: "SEARCH...",
                          onChange: (event) => setQuery(event.target.value)
                        })
                      ]
                    }),
                    filteredChapters.length > 0 && /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Combobox.Options, {
                      static: !0,
                      className: "max-h-72 scroll-py-2 overflow-y-auto border-t border-green-600 py-2 text-sm text-gray-300",
                      children: filteredChapters.map((chapter) => /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react3.Combobox.Option, {
                        value: chapter,
                        className: ({ active }) => classNames(
                          "cursor-default select-none px-4 py-2",
                          active && "bg-green-600 text-white"
                        ),
                        children: chapter.name
                      }, chapter.href))
                    }),
                    query !== "" && filteredChapters.length === 0 && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", {
                      className: "p-4 text-center text-sm text-gray-300",
                      children: "No actions found."
                    })
                  ]
                })
              ]
            })
          })
        })
      ]
    })
  });
}

// app/root.tsx
var import_jsx_runtime = require("react/jsx-runtime"), links = () => [{ rel: "stylesheet", href: tailwind_default }], meta = () => ({
  charset: "utf-8",
  title: "Hands-on-hacking",
  viewport: "width=device-width,initial-scale=1"
}), options = new import_docker_cli_js.Options(void 0, void 0, !1), logos = [
  import_free_solid_svg_icons2.faUserSecret,
  import_free_solid_svg_icons2.faSkullCrossbones,
  import_free_solid_svg_icons2.faUserNinja,
  import_free_solid_svg_icons2.faRadiation,
  import_free_solid_svg_icons2.faBiohazard,
  import_free_solid_svg_icons2.faSpider
], loader = async () => {
  let logoIndex = Math.floor(Math.random() * logos.length), chaptersData = await getChapters(), chapters = await Promise.allSettled(
    chaptersData.map(
      (chapter) => new Promise((resolve) => {
        (0, import_docker_cli_js.dockerCommand)(`inspect ${chapter.containerName}`, options).then((data) => {
          let { object } = data, container = object.find(
            (container2) => container2.Name === `/${chapter.containerName}`
          ), isRunning = !0;
          container.State.Status === "exited" /* EXITED */ && (isRunning = !1), resolve({
            name: chapter.menuTitle,
            href: `chapters/${chapter.index}`,
            icon: import_free_regular_svg_icons.faFolder,
            isRunning
          });
        }).catch((error) => {
          resolve({
            name: chapter.menuTitle,
            href: `chapters/${chapter.index}`,
            icon: import_free_regular_svg_icons.faFolder,
            isRunning: !1
          });
        });
      })
    )
  ).then((data) => data.map((item) => item.value));
  return (0, import_node2.json)({
    chapters,
    logoIndex
  });
};
function App() {
  let [sidebarOpen, setSidebarOpen] = (0, import_react6.useState)(!1), data = (0, import_react5.useLoaderData)(), isHome = (0, import_react5.useLocation)().pathname === "/", menu = data.chapters.map((item) => /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react5.NavLink, {
    to: {
      pathname: item.href
    },
    className: ({ isActive }) => classNames(
      isActive ? "bg-green-800 text-white" : "text-gray-300 hover:text-white",
      "group flex items-center rounded-md px-2 py-2 text-sm font-medium hover:bg-green-700"
    ),
    onClick: () => setSidebarOpen(!1),
    children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome2.FontAwesomeIcon, {
        icon: item.isRunning ? import_free_regular_svg_icons.faFolderOpen : import_free_regular_svg_icons.faFolder,
        className: classNames(
          item.isRunning ? "text-green-300" : "text-green-400 group-hover:text-green-300",
          "mr-3 h-6 w-6 flex-shrink-0"
        ),
        "aria-hidden": "true"
      }),
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", {
        className: "flex-1",
        children: item.name
      }),
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)(MachineStatusIcon_default, {
        isRunning: item.isRunning,
        hideStoppedState: !0
      })
    ]
  }, item.name));
  return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("html", {
    lang: "en",
    className: "h-full bg-black",
    children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("head", {
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Meta, {}),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Links, {})
        ]
      }),
      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("body", {
        className: "h-full font-mono",
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(CommandPalette, {
            chapters: [
              ...data.chapters,
              {
                name: "Advanced Attacks",
                href: "chapters/advanced",
                icon: import_free_regular_svg_icons.faFolder,
                isRunning: !1
              }
            ]
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react7.Transition.Root, {
                show: sidebarOpen,
                as: import_react6.Fragment,
                children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react7.Dialog, {
                  as: "div",
                  className: "relative z-40 md:hidden",
                  onClose: setSidebarOpen,
                  children: [
                    /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react7.Transition.Child, {
                      as: import_react6.Fragment,
                      enter: "transition-opacity ease-linear duration-300",
                      enterFrom: "opacity-0",
                      enterTo: "opacity-100",
                      leave: "transition-opacity ease-linear duration-300",
                      leaveFrom: "opacity-100",
                      leaveTo: "opacity-0",
                      children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                        className: "fixed inset-0 bg-black bg-opacity-75"
                      })
                    }),
                    /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                      className: "fixed inset-0 z-40 flex",
                      children: [
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react7.Transition.Child, {
                          as: import_react6.Fragment,
                          enter: "transition ease-in-out duration-300 transform",
                          enterFrom: "-translate-x-full",
                          enterTo: "translate-x-0",
                          leave: "transition ease-in-out duration-300 transform",
                          leaveFrom: "translate-x-0",
                          leaveTo: "-translate-x-full",
                          children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react7.Dialog.Panel, {
                            className: "relative flex w-full max-w-xs flex-1 flex-col bg-black",
                            children: [
                              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react7.Transition.Child, {
                                as: import_react6.Fragment,
                                enter: "ease-in-out duration-300",
                                enterFrom: "opacity-0",
                                enterTo: "opacity-100",
                                leave: "ease-in-out duration-300",
                                leaveFrom: "opacity-100",
                                leaveTo: "opacity-0",
                                children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                                  className: "absolute top-0 right-0 -mr-12 pt-2",
                                  children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("button", {
                                    type: "button",
                                    className: "ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white",
                                    onClick: () => setSidebarOpen(!1),
                                    children: [
                                      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", {
                                        className: "sr-only",
                                        children: "Close sidebar"
                                      }),
                                      /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome2.FontAwesomeIcon, {
                                        icon: import_free_solid_svg_icons2.faTimes,
                                        className: "h-5 w-5 text-white",
                                        "aria-hidden": "true"
                                      })
                                    ]
                                  })
                                })
                              }),
                              /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                                className: "fieldset h-0 flex-1 overflow-y-auto pt-5 pb-4",
                                children: [
                                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                                    className: "flex flex-shrink-0 items-center px-4",
                                    children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                                      className: "h-12 w-full text-center font-mono text-xl font-bold text-green-500",
                                      children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Link, {
                                        to: ".",
                                        children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome2.FontAwesomeIcon, {
                                          className: "mx-auto h-full",
                                          icon: logos[data.logoIndex]
                                        })
                                      })
                                    })
                                  }),
                                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("nav", {
                                    className: "mt-5 space-y-2 border-t-4 border-double border-green-600 px-2 pt-6",
                                    children: menu
                                  })
                                ]
                              })
                            ]
                          })
                        }),
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                          className: "w-14 flex-shrink-0"
                        })
                      ]
                    })
                  ]
                })
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                className: "hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col md:pr-3",
                children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                  className: "flex min-h-0 flex-1 flex-col",
                  children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                    className: "flex flex-1 flex-col overflow-y-auto",
                    children: [
                      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
                        className: "fieldset",
                        children: [
                          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                            className: "legend",
                            children: "Logo"
                          }),
                          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                            className: "flex h-24 flex-shrink-0 items-center justify-center",
                            children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                              className: "h-12 w-full text-center font-mono text-xl font-bold text-green-500",
                              children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Link, {
                                to: ".",
                                children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome2.FontAwesomeIcon, {
                                  className: "mx-auto h-full",
                                  icon: logos[data.logoIndex]
                                })
                              })
                            })
                          })
                        ]
                      }),
                      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
                        className: "fieldset mt-3 flex-1 ",
                        children: [
                          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                            className: "legend",
                            children: "Menu"
                          }),
                          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("nav", {
                            className: " space-y-1 px-2 pt-5",
                            children: menu
                          })
                        ]
                      })
                    ]
                  })
                })
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                className: "flex flex-1 flex-col md:pl-64",
                children: [
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                    className: "sticky top-0 z-10 bg-black pl-1 pt-1 sm:pl-3 sm:pt-3 md:hidden",
                    children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("button", {
                      type: "button",
                      className: "-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500",
                      onClick: () => setSidebarOpen(!0),
                      children: [
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", {
                          className: "sr-only",
                          children: "Open sidebar"
                        }),
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome2.FontAwesomeIcon, {
                          icon: import_free_solid_svg_icons2.faBars,
                          "aria-hidden": "true",
                          className: "h-5 w-5 text-white"
                        })
                      ]
                    })
                  }),
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("main", {
                    className: "w-full flex-1 text-gray-300",
                    children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
                      className: "fieldset min-h-screen",
                      children: [
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                          className: "legend",
                          children: isHome ? "Welcome" : "Vulnerability"
                        }),
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Outlet, {})
                      ]
                    })
                  })
                ]
              })
            ]
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.ScrollRestoration, {}),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.Scripts, {}),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react5.LiveReload, {})
        ]
      })
    ]
  });
}

// app/routes/chapters.tsx
var chapters_exports = {};
__export(chapters_exports, {
  default: () => ChaptersPage
});
var import_react8 = require("@remix-run/react"), import_jsx_runtime = require("react/jsx-runtime");
function ChaptersPage() {
  return /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react8.Outlet, {});
}

// app/routes/chapters/$chapterId.tsx
var chapterId_exports = {};
__export(chapterId_exports, {
  CatchBoundary: () => CatchBoundary,
  ErrorBoundary: () => ErrorBoundary,
  action: () => action,
  default: () => ChapterIdIndexPage,
  loader: () => loader2
});
var import_react9 = require("@remix-run/react"), import_node3 = require("@remix-run/node"), import_docker_cli_js2 = require("docker-cli-js"), import_tiny_invariant = __toESM(require("tiny-invariant"));
var import_react10 = require("react"), import_react_fontawesome3 = require("@fortawesome/react-fontawesome"), import_free_solid_svg_icons3 = require("@fortawesome/free-solid-svg-icons"), import_free_solid_svg_icons4 = require("@fortawesome/free-solid-svg-icons");
var import_child_process = __toESM(require("child_process")), import_jsx_runtime = require("react/jsx-runtime");
function ErrorBoundary({ error }) {
  return console.error(error), /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
    className: "py-6",
    children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
      className: "mx-auto max-w-7xl px-4 sm:px-6 lg:px-8",
      children: [
        "An unexpected error occurred: ",
        error.message
      ]
    })
  });
}
function CatchBoundary() {
  let caught = (0, import_react9.useCatch)();
  if (caught.status === 404)
    return /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
      className: "py-6",
      children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
        className: "mx-auto max-w-7xl px-4 sm:px-6 lg:px-8",
        children: "Chapter not found"
      })
    });
  throw new Error(`Unexpected caught response with status: ${caught.status}`);
}
var action = async ({ request }) => {
  let formData = await request.formData(), action2 = formData.get("action"), chapterId = formData.get("chapterId"), chapter = await getChapter({ index: Number(chapterId) });
  if (!chapter)
    throw new Response("Not Found", { status: 404 });
  let dockerAction = action2 === "start" ? "up -d" : action2 === "stop" ? "down" : action2;
  try {
    import_child_process.default.execSync(
      `docker compose -p ${chapter.composerName} -f ${chapter.composerFileLocation} ${dockerAction}`
    ).toString();
  } catch (error) {
    throw new Response(error.stderr.toString(), { status: 500 });
  }
  return null;
}, loader2 = async ({ params }) => {
  let options2 = new import_docker_cli_js2.Options(void 0, void 0, !1);
  (0, import_tiny_invariant.default)(params.chapterId, "chapterId not found");
  let chapterId = Number(params.chapterId);
  if (Number.isNaN(chapterId))
    throw new Response("Not Found", { status: 404 });
  let chapter = await getChapter({ index: Number(chapterId) });
  if (!chapter)
    throw new Response("Not Found", { status: 404 });
  let container = {
    State: {
      Status: "exited"
    },
    NetworkSettings: {
      Ports: []
    }
  };
  try {
    let data = await (0, import_docker_cli_js2.dockerCommand)(`inspect ${chapter.containerName}`, options2), { object } = data;
    container = object.find(
      (container2) => container2.Name === `/${chapter.containerName}`
    );
  } catch {
  }
  return (0, import_node3.json)({
    containerState: container.State,
    ports: container.NetworkSettings.Ports,
    title: chapter.title,
    subTitle: `Chapter ${chapter.index}`,
    description: chapter.description,
    hasContainer: chapter.containerName !== ""
  });
}, MachineStatusAlert = ({ state }) => {
  let message2 = "Instance is running", isRunning = !0;
  if (["running" /* RUNNING */, "exited" /* EXITED */].includes(state))
    state === "exited" /* EXITED */ && (message2 = "Instance is stopped", isRunning = !1);
  else
    return null;
  return /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
    className: classNames(
      isRunning ? "border-green-800" : "border-red-800",
      "border-2 p-4"
    ),
    children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
      className: "flex items-center",
      children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
          className: "flex-0",
          children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(MachineStatusIcon_default, {
            isRunning
          })
        }),
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
          className: "flex-1 text-center",
          children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h3", {
            className: classNames(
              isRunning ? "text-green-500" : "text-red-500",
              "text-sm font-medium uppercase"
            ),
            children: message2
          })
        })
      ]
    })
  });
}, Details = ({
  state,
  chapterId,
  isUpdating,
  ports,
  location
}) => /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_jsx_runtime.Fragment, {
  children: [
    /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h2", {
      className: "sr-only",
      children: "Details"
    }),
    /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
      className: "mt-2",
      children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(MachineStatusAlert, {
        state
      })
    }),
    /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
      className: "mt-6 border-t border-green-900 pt-6 pb-6 xl:pb-0",
      children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_react9.Form, {
        method: "post",
        className: "flex justify-center",
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("input", {
            type: "hidden",
            name: "chapterId",
            value: chapterId
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("button", {
            type: "submit",
            name: "action",
            value: state === "running" /* RUNNING */ ? "stop" : "start",
            disabled: isUpdating,
            className: classNames(
              state === "running" /* RUNNING */ ? "bg-red-600 hover:bg-red-700 focus:ring-red-500" : "bg-green-600 hover:bg-green-700 focus:ring-green-500",
              isUpdating ? "cursor-not-allowed opacity-50" : "",
              "inline-flex items-center rounded-md border border-transparent px-4 py-2 text-sm font-medium uppercase text-white shadow-sm  focus:outline-none focus:ring-2  focus:ring-offset-2"
            ),
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome3.FontAwesomeIcon, {
                icon: isUpdating ? import_free_solid_svg_icons3.faCircleNotch : state === "running" /* RUNNING */ ? import_free_solid_svg_icons4.faStop : import_free_solid_svg_icons4.faPlay,
                className: classNames(
                  isUpdating ? "animate-spin-slow" : "",
                  "-ml-1 mr-2 h-5 w-5"
                ),
                "aria-hidden": "true"
              }),
              state === "running" /* RUNNING */ ? `Stop${isUpdating ? "ping" : ""}` : `Start${isUpdating ? "ing" : ""}`,
              " ",
              "instance"
            ]
          })
        ]
      })
    }),
    Object.keys(ports).length ? /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
      className: "fieldset-thin mb-6 xl:mt-6 xl:mb-0",
      children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
          className: "legend",
          children: "Open ports"
        }),
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("ul", {
          children: Object.keys(ports).map((port) => ports[port][0].HostPort).map((port) => /* @__PURE__ */ (0, import_jsx_runtime.jsx)("li", {
            className: "my-2",
            children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("a", {
              href: `${location}:${port}`,
              target: "_blank",
              rel: "noreferrer",
              className: "m-3 flex cursor-pointer items-center bg-green-600 p-2 uppercase text-black hover:bg-green-700",
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("span", {
                  className: "flex-1",
                  children: [
                    location.substring(2),
                    ":",
                    port
                  ]
                }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome3.FontAwesomeIcon, {
                  icon: import_free_solid_svg_icons3.faArrowUpRightFromSquare,
                  className: "h-4"
                })
              ]
            })
          }, port))
        })
      ]
    }) : null
  ]
}), MissingContainer = () => /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
  children: "This chapter doesn't need a container"
});
function ChapterIdIndexPage() {
  let [location, setLocation] = (0, import_react10.useState)(""), params = (0, import_react9.useParams)(), data = (0, import_react9.useLoaderData)(), transition = (0, import_react9.useTransition)(), isUpdating = Boolean(transition.submission), chapterId = params.chapterId, { title, subTitle, description, containerState, ports, hasContainer } = data;
  (0, import_react10.useEffect)(() => {
    setLocation(`//${window.location.hostname}`);
  }, []);
  let detailsBlock = /* @__PURE__ */ (0, import_jsx_runtime.jsx)(Details, {
    state: containerState.Status,
    isUpdating,
    ports,
    chapterId,
    location
  });
  return /* @__PURE__ */ (0, import_jsx_runtime.jsx)("main", {
    className: "flex-1",
    children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
      className: "py-8 xl:py-10",
      children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
        className: "mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 xl:grid xl:max-w-6xl xl:grid-cols-3",
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
            className: "xl:col-span-2 ",
            children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
              className: "fieldset-single p-4",
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                  className: "legend",
                  children: "Info"
                }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                  className: "border-green-900 md:flex md:items-center md:justify-between md:space-x-4 xl:border-b xl:pb-6",
                  children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                    className: "w-full space-y-2",
                    children: [
                      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h2", {
                        className: "border border-orange-400 p-1 text-center text-xs font-bold uppercase text-orange-400",
                        children: subTitle
                      }),
                      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h1", {
                        className: " bg-yellow-400 p-1 text-center text-2xl font-bold text-black",
                        children: title
                      })
                    ]
                  })
                }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("aside", {
                  className: "mt-8 border-b border-green-900 xl:hidden",
                  children: [
                    hasContainer && detailsBlock,
                    !hasContainer && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                      className: "pb-8 text-center",
                      children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(MissingContainer, {})
                    })
                  ]
                }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                  className: "py-3 xl:pt-6 xl:pb-0",
                  children: [
                    /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h2", {
                      className: "sr-only",
                      children: "Description"
                    }),
                    /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                      className: "prose max-w-none space-y-3",
                      children: description == null ? void 0 : description.split(`
`).map((line, index) => /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", {
                        children: line
                      }, index))
                    })
                  ]
                })
              ]
            })
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("aside", {
            className: "hidden xl:block xl:pl-8",
            children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("fieldset", {
              className: "fieldset-single px-4 pb-4",
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("legend", {
                  className: "legend",
                  children: "Details"
                }),
                hasContainer && detailsBlock,
                !hasContainer && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                  className: "mt-3 text-center",
                  children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(MissingContainer, {})
                })
              ]
            })
          })
        ]
      })
    })
  });
}

// app/routes/chapters/advanced.tsx
var advanced_exports = {};
__export(advanced_exports, {
  default: () => AdvancedChapterPage
});
var import_free_solid_svg_icons5 = require("@fortawesome/free-solid-svg-icons"), import_react_fontawesome4 = require("@fortawesome/react-fontawesome"), import_jsx_runtime = require("react/jsx-runtime");
function AdvancedChapterPage() {
  return /* @__PURE__ */ (0, import_jsx_runtime.jsx)("main", {
    className: "flex h-[calc(100vh-21px)] items-center justify-center overflow-auto",
    children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
      className: "py-6",
      children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
        className: "mx-auto max-w-7xl px-4 text-center font-bold uppercase sm:px-6 lg:px-8",
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
            className: "box-content rotate-180 border-t-2 border-gray-300 leading-4",
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                children: "__|__|__|__|__|__|__|__|__|__|__|__|__|__|__|_"
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                children: "|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__"
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                children: "_|__|__|__|__|__|__|__|__|__|__|__|__|__|__|_"
              })
            ]
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
            className: "my-6",
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h1", {
                children: "Sorry"
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h2", {
                children: "But your advanced attacks is in another book"
              })
            ]
          }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
            className: "pt-12 leading-4",
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
                className: "mb-6 h-10 w-full  text-gray-300",
                children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_react_fontawesome4.FontAwesomeIcon, {
                  className: "h-full w-full",
                  icon: import_free_solid_svg_icons5.faBook
                })
              }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
                className: "box-content border-t-2 border-gray-300 leading-4",
                children: [
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                    children: "|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__"
                  }),
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                    children: "_|__|__|__|__|__|__|__|__|__|__|__|__|__|__|_"
                  }),
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
                    children: "|__|__|__|__|__|__|__|__|__|__|__|__|__|__|__"
                  })
                ]
              })
            ]
          })
        ]
      })
    })
  });
}

// app/routes/index.tsx
var routes_exports = {};
__export(routes_exports, {
  default: () => DefaultIndexPage
});
var import_jsx_runtime = require("react/jsx-runtime"), message = ` _   _        _  _        
| | | |  ___ | || |  ___  
| |_| | / _ \\| || | / _ \\ 
|  _  ||  __/| || || (_) |
|_| |_| \\___||_||_| \\___/ 
`;
function DefaultIndexPage() {
  return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
    className: "py-6",
    children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
        className: "mx-auto max-w-7xl px-4 sm:px-6 lg:px-8",
        children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h1", {
          className: "bg-yellow-400 text-center text-2xl font-semibold uppercase text-black",
          children: "Welcome"
        })
      }),
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", {
        className: "mx-auto max-w-7xl px-4 sm:px-6 md:px-8",
        children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", {
          className: "py-4 text-center text-green-500",
          children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("p", {
              className: "uppercase",
              children: [
                "Select a chapter from the ",
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("b", {
                  children: "Menu"
                }),
                " and start hacking!"
              ]
            }),
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("pre", {
              className: "font-xs mt-3 leading-5",
              dangerouslySetInnerHTML: { __html: message }
            })
          ]
        })
      })
    ]
  });
}

// server-assets-manifest:@remix-run/dev/assets-manifest
var assets_manifest_default = { version: "6cc6d29e", entry: { module: "/build/entry.client-AHXDIVED.js", imports: ["/build/_shared/chunk-HMK2I5IY.js", "/build/_shared/chunk-V5M25JL4.js", "/build/_shared/chunk-B7AP56NU.js"] }, routes: { root: { id: "root", parentId: void 0, path: "", index: void 0, caseSensitive: void 0, module: "/build/root-MOTNCPPT.js", imports: ["/build/_shared/chunk-L6QWH6BF.js", "/build/_shared/chunk-SNPRDTKD.js"], hasAction: !1, hasLoader: !0, hasCatchBoundary: !1, hasErrorBoundary: !1 }, "routes/chapters": { id: "routes/chapters", parentId: "root", path: "chapters", index: void 0, caseSensitive: void 0, module: "/build/routes/chapters-3LIV2FR4.js", imports: void 0, hasAction: !1, hasLoader: !1, hasCatchBoundary: !1, hasErrorBoundary: !1 }, "routes/chapters/$chapterId": { id: "routes/chapters/$chapterId", parentId: "routes/chapters", path: ":chapterId", index: void 0, caseSensitive: void 0, module: "/build/routes/chapters/$chapterId-7B63V637.js", imports: ["/build/_shared/chunk-L6QWH6BF.js", "/build/_shared/chunk-SNPRDTKD.js"], hasAction: !0, hasLoader: !0, hasCatchBoundary: !0, hasErrorBoundary: !0 }, "routes/chapters/advanced": { id: "routes/chapters/advanced", parentId: "routes/chapters", path: "advanced", index: void 0, caseSensitive: void 0, module: "/build/routes/chapters/advanced-H3XLPXJC.js", imports: ["/build/_shared/chunk-SNPRDTKD.js"], hasAction: !1, hasLoader: !1, hasCatchBoundary: !1, hasErrorBoundary: !1 }, "routes/index": { id: "routes/index", parentId: "root", path: void 0, index: !0, caseSensitive: void 0, module: "/build/routes/index-5BLKH6UT.js", imports: void 0, hasAction: !1, hasLoader: !1, hasCatchBoundary: !1, hasErrorBoundary: !1 } }, url: "/build/manifest-6CC6D29E.js" };

// server-entry-module:@remix-run/dev/server-build
var assetsBuildDirectory = "public/build", publicPath = "/build/", entry = { module: entry_server_exports }, routes = {
  root: {
    id: "root",
    parentId: void 0,
    path: "",
    index: void 0,
    caseSensitive: void 0,
    module: root_exports
  },
  "routes/chapters": {
    id: "routes/chapters",
    parentId: "root",
    path: "chapters",
    index: void 0,
    caseSensitive: void 0,
    module: chapters_exports
  },
  "routes/chapters/$chapterId": {
    id: "routes/chapters/$chapterId",
    parentId: "routes/chapters",
    path: ":chapterId",
    index: void 0,
    caseSensitive: void 0,
    module: chapterId_exports
  },
  "routes/chapters/advanced": {
    id: "routes/chapters/advanced",
    parentId: "routes/chapters",
    path: "advanced",
    index: void 0,
    caseSensitive: void 0,
    module: advanced_exports
  },
  "routes/index": {
    id: "routes/index",
    parentId: "root",
    path: void 0,
    index: !0,
    caseSensitive: void 0,
    module: routes_exports
  }
};
// Annotate the CommonJS export names for ESM import in node:
0 && (module.exports = {
  assets,
  assetsBuildDirectory,
  entry,
  publicPath,
  routes
});
