@extends('app')
@section('content')
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <section class="ftco-about img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
                    <div class="container-fluid px-0">
                        <div class="row d-flex">
                            <div class="col-md-6 d-flex">
                                <div class="img d-flex align-self-stretch align-items-center js-fullheight"
                                     style="background-image:url(/images/about.jpg);">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="text px-4 pt-5 pt-md-0 px-md-4 pr-md-5 ftco-animate">
                                    <h2 class="mb-4">I'm <span>Test page</span></h2>
                                    <p>The kernel in Linux handles all operating system processes, such as memory
                                        management, task scheduling, I/O, interprocess communication, and overall system
                                        control. This is loaded in two stages – in the first stage, the kernel (as a
                                        compressed image file) is loaded into memory and decompressed, and a few
                                        fundamental functions such as basic memory management are set up. Control is
                                        then switched one final time to the main kernel start process. Once the kernel
                                        is fully operational – and as part of its startup, upon being loaded and
                                        executing – the kernel looks for an init process to run, which (separately) sets
                                        up a user space and the processes needed for a user environment and ultimate
                                        login. The kernel itself is then allowed to go idle, subject to calls from other
                                        processes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
