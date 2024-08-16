<div class="w-screen" >
    <img loading="lazy" src="{{asset('images/client-info-bg.png')}}" alt=""
         class="absolute object-cover h-screen w-screen bg-cover bg-center opacity-25">
    <section class="flex flex-col justify-center  items-center py-0 bg-white ">
        <div  class="flex relative flex-col items-center px-20  max-w-full  w-screen max-md:px-5 max-md:py-24">
            <form wire:submit="create" class="flex flex-col px-5 w-full mt-10 lg:max-w-7xl md:max-w-4xl">
                {{ $this->form }}
{{--                <button type="submit">--}}
{{--                    Submit--}}
{{--                </button>--}}
            </form>
            <x-filament-actions::modals />
        </div>
    </section>

</div>
