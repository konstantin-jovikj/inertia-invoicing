@pageBreak
<div class="footer my-10 ">
    @if ($document->is_for_export)
        Page @pageNumber of @totalPages
    @else
        Страница @pageNumber од @totalPages
    @endif

</div>

<style>
    .footer {
        position: fixed;
        color: gray;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        text-align: center;
        line-height: 20px;
        /* border-top: 1px solid #bbb9b9; */
        font-size: 9px;
    }
</style>
